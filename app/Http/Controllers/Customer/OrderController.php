<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * OrderController (Customer)
 * Controller untuk menampilkan order list dan detail customer
 */
class OrderController extends Controller
{
    protected OrderService $orderService;
    protected MidtransService $midtransService;

    public function __construct(OrderService $orderService, MidtransService $midtransService)
    {
        $this->orderService = $orderService;
        $this->midtransService = $midtransService;
    }

    /**
     * Display list of user orders.
     * Tampilkan semua order customer
     */
    public function index()
    {
        $orders = $this->orderService->getUserOrders(Auth::id(), 10);
        $userOrders = Auth::user()->orders;

        $totalOrders = $userOrders->count();
        $completedOrders = $userOrders->where('status', 'completed')->count();
        $pendingOrders = $userOrders->whereIn('status', ['pending', 'processed'])->count();
        $totalSpent = $userOrders->where('status', 'completed')->sum('total');

        return view('customer.orders.index', compact('orders', 'totalOrders', 'completedOrders', 'pendingOrders', 'totalSpent'));
    }

    /**
     * Display order detail.
     * Tampilkan detail order dengan items, payment, address
     */
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if ($order->payment && $order->payment_status !== 'paid') {
            $status = $this->midtransService->checkTransactionStatus($order->order_number);

            if ($status && $status['transaction_status']) {
                $mappedStatus = $this->midtransService->mapPaymentStatus($status['transaction_status']);

                $order->payment->update([
                    'transaction_id' => $status['transaction_id'],
                    'payment_type'   => $status['payment_type'],
                    'status'         => $status['transaction_status'],
                    'payload'        => $status,
                ]);

                $order->update(['payment_status' => $mappedStatus]);
            }
        }

        $order->load([
            'orderItems.product',
            'payment',
            'shippingAddress',
        ]);

        return view('customer.orders.show', compact('order'));
    }

    /**
     * Tampilkan halaman pembayaran dengan Snap popup
     */
    public function pay(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if (!$order->canPay()) {
            return back()->with('error', 'Order ini tidak bisa dibayar lagi.');
        }

        if (!$order->snap_token) {
            $snapToken = $this->midtransService->generateSnapToken($order);
            $order->update(['snap_token' => $snapToken]);
        }

        $order->load('payment');

        return view('customer.orders.pay', compact('order'));
    }

    /**
     * Callback setelah pembayaran selesai (finish/cancel)
     */
    public function paymentFinish(Request $request)
    {
        $order = Order::where('order_number', $request->order_id)->first();

        if (!$order) {
            return redirect()->route('customer.orders.index')
                ->with('error', 'Order tidak ditemukan.');
        }

        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if ($order->payment && $order->payment_status !== 'paid') {
            $status = $this->midtransService->checkTransactionStatus($order->order_number);

            if ($status && $status['transaction_status']) {
                $mappedStatus = $this->midtransService->mapPaymentStatus($status['transaction_status']);

                $order->payment->update([
                    'transaction_id' => $status['transaction_id'],
                    'payment_type'   => $status['payment_type'],
                    'status'         => $status['transaction_status'],
                    'payload'        => $status,
                ]);

                $order->update(['payment_status' => $mappedStatus]);
            }
        }

        return redirect()->route('customer.orders.show', $order)
            ->with('success', 'Status pembayaran telah diperbarui.');
    }

    /**
     * Upload payment proof.
     * Customer upload bukti pembayaran
     */
    public function uploadPayment(Request $request, Order $order)
    {
        // Cek ownership
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Validasi order harus bisa dibayar
        if (!$order->canPay()) {
            return back()->with('error', 'Order ini tidak bisa dibayar!');
        }

        // Validasi file
        $validated = $request->validate([
            'proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'proof.required' => 'Bukti pembayaran harus diupload',
            'proof.image' => 'File harus berupa gambar',
            'proof.mimes' => 'Format yang diizinkan: jpeg, png, jpg',
            'proof.max' => 'Ukuran maksimal 2MB',
        ]);

        try {
            // Upload file ke storage/public/payments
            $filePath = $request->file('proof')->store('payments', 'public');

            // Update payment
            $order->payment->update([
                'proof' => $filePath,
                'status' => 'pending', // Menunggu verifikasi admin
                'uploaded_at' => now(),
            ]);

            // Update order payment status
            $order->update(['payment_status' => 'pending']);

            return back()
                ->with('success', 'Bukti pembayaran berhasil diupload! ' .
                    'Menunggu verifikasi dari admin.');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error upload: ' . $e->getMessage());
        }
    }

    /**
     * Cancel order.
     * Customer cancel order yang pending/processed
     */
    public function cancel(Order $order)
    {
        // Cek ownership
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Validasi hanya pending/processed yang bisa dibatalkan
        if (!in_array($order->status, ['pending', 'processed'])) {
            return back()->with('error', 'Order tidak bisa dibatalkan!');
        }

        try {
            $this->orderService->cancelOrder($order->id);

            return back()
                ->with('success', "Order {$order->order_number} berhasil dibatalkan. " .
                    "Stok produk telah dikembalikan.");

        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Download invoice.
     * Customer download invoice order
     */
    public function downloadInvoice(Order $order)
    {
        // Cek ownership
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Buat PDF invoice (jika sudah ada library seperti mPDF atau DomPDF)
        // Untuk sekarang, arahkan ke halaman printable
        return view('customer.orders.invoice', compact('order'));
    }

    /**
     * Get order status history.
     * Lihat timeline status order
     */
    public function statusHistory(Order $order)
    {
        // Cek ownership
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // TODO: Implement OrderStatus model untuk track history
        // Untuk sekarang return basic info
        $history = [
            [
                'status' => 'pending',
                'date' => $order->created_at,
                'message' => 'Order dibuat',
            ],
        ];

        if ($order->payment_status === 'paid') {
            $history[] = [
                'status' => 'paid',
                'date' => $order->payment->verified_at,
                'message' => 'Pembayaran diverifikasi',
            ];
        }

        if ($order->status === 'processed') {
            // TODO: Get dari order status history
            $history[] = [
                'status' => 'processed',
                'date' => $order->updated_at,
                'message' => 'Order diproses',
            ];
        }

        return response()->json($history);
    }
}
