<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\ShippingAddress;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * OrderService
 * Service layer untuk menangani business logic order & checkout
 * 
 * CRITICAL: Checkout logic harus dalam transaction!
 * Jika ada error, semua perubahan harus di-rollback
 */
class OrderService
{
    /**
     * Dependency injection
     */
    protected StockService $stockService;
    protected MidtransService $midtransService;

    public function __construct(StockService $stockService, MidtransService $midtransService)
    {
        $this->stockService = $stockService;
        $this->midtransService = $midtransService;
    }

    /**
     * Process checkout
     * 
     * CRITICAL TRANSACTION SECTION:
     * 1. Validasi cart & stok
     * 2. Buat order dengan nomor unik
     * 3. Buat order items
     * 4. Reduce stok
     * 5. Buat payment record
     * 6. Clear cart
     * 
     * Jika ada error di step apapun, semua rollback!
     */
    public function checkout(int $shippingAddressId): Order {
        // Get cart
        $cart = Cart::where('user_id', Auth::id())
            ->with('cartItems.product')
            ->first();

        // Validasi cart ada dan tidak kosong
        if (!$cart || $cart->cartItems->isEmpty()) {
            throw new \Exception("Keranjang belanja kosong!");
        }

        // Validasi address ownership
        $address = ShippingAddress::findOrFail($shippingAddressId);
        if ($address->user_id !== Auth::id()) {
            throw new \Exception("Unauthorized access to address");
        }

        // TRANSACTION BEGIN
        return DB::transaction(function () use (
            $cart,
            $shippingAddressId,
            $address
        ) {
            // ========================================
            // STEP 1: Validate stock
            // ========================================
            foreach ($cart->cartItems as $item) {
                if (!$item->product->hasStock($item->qty)) {
                    throw new \Exception(
                        "Stok {$item->product->name} tidak mencukupkan! " .
                        "Stok tersedia: {$item->product->stock}, " .
                        "diminta: {$item->qty}"
                    );
                }
            }

            // ========================================
            // STEP 2: Create order
            // ========================================
            $order = Order::create([
                'user_id' => Auth::id(),
                'shipping_address_id' => $shippingAddressId,
                'order_number' => Order::generateOrderNumber(),
                'total' => $cart->total,
                'status' => 'pending',
                'payment_status' => 'unpaid',
            ]);

            // ========================================
            // STEP 3: Create order items & reduce stock
            // ========================================
            foreach ($cart->cartItems as $item) {
                // Create order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'qty' => $item->qty,
                    'price' => $item->price,
                    'subtotal' => $item->qty * $item->price,
                ]);

                // Reduce stock
                $this->stockService->reduceStockForSale(
                    $item->product_id,
                    $item->qty,
                    $order->id
                );
            }

            // ========================================
            // STEP 4: Create payment record
            // ========================================
            Payment::create([
                'order_id'     => $order->id,
                'gross_amount' => $cart->total,
                'status'       => 'pending',
            ]);

            // ========================================
            // STEP 5: Clear cart
            // ========================================
            $cart->cartItems()->delete();

            return $order;
        });
    }

    /**
     * Get user orders
     */
    public function getUserOrders(int $userId, int $perPage = 10)
    {
        return Order::where('user_id', $userId)
            ->with(['orderItems.product', 'payment', 'shippingAddress'])
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get order detail
     */
    public function getOrderDetail(int $orderId): Order
    {
        return Order::with([
            'user',
            'orderItems.product',
            'payment',
            'shippingAddress'
        ])
            ->findOrFail($orderId);
    }

    /**
     * Verify payment & update order status
     * Digunakan admin untuk verifikasi pembayaran
     */
    public function verifyPayment(int $orderId, bool $approved = true): Order
    {
        return DB::transaction(function () use ($orderId, $approved) {
            $order = Order::with('orderItems')->findOrFail($orderId);

            if ($approved) {
                $order->payment->update([
                    'status' => 'verified',
                    'verified_at' => now(),
                ]);

                $order->update(['payment_status' => 'paid']);

                if ($order->status === 'pending') {
                    $order->update(['status' => 'processed']);
                }
            } else {
                $order->payment->update(['status' => 'rejected']);
                $order->update(['payment_status' => 'rejected']);

                $this->stockService->restoreStockForRejection($order->id);
            }

            return $order->refresh();
        });
    }

    /**
     * Update order status (admin)
     */
    public function updateOrderStatus(int $orderId, string $status): Order
    {
        // Validate status
        $validStatuses = ['pending', 'processed', 'shipped', 'completed', 'cancelled'];
        if (!in_array($status, $validStatuses)) {
            throw new \Exception("Invalid order status: $status");
        }

        $order = Order::findOrFail($orderId);
        $order->update(['status' => $status]);

        return $order->refresh();
    }

    /**
     * Cancel order & refund stok
     * CRITICAL: Harus restore stok yang sudah dikurangi
     */
    public function cancelOrder(int $orderId): Order
    {
        return DB::transaction(function () use ($orderId) {
            $order = Order::with('orderItems')->findOrFail($orderId);

            // Validasi hanya pending atau processed yang bisa di-cancel
            if (!in_array($order->status, ['pending', 'processed'])) {
                throw new \Exception("Hanya order pending/processed yang bisa dibatalkan");
            }

            // Restore stok
            foreach ($order->orderItems as $item) {
                // Create stok masuk untuk refund
                // Ini akan menambah stok kembali
                $this->stockService->stockIn(
                    $item->product_id,
                    $item->qty,
                    null,
                    now()->format('Y-m-d'),
                    "Refund dari order {$order->order_number}"
                );
            }

            // Update order status
            $order->update(['status' => 'cancelled']);

            return $order;
        });
    }

    /**
     * Get order statistics
     */
    public function getOrderStats()
    {
        return [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'unpaid_amount' => Order::where('payment_status', 'unpaid')->sum('total'),
        ];
    }
}
