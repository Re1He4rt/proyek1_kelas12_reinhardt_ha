<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Services\OrderService;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * PaymentController
 * Controller untuk verifikasi dan manage pembayaran dari admin
 */
class PaymentController extends Controller
{
    protected OrderService $orderService;
    protected StockService $stockService;

    public function __construct(OrderService $orderService, StockService $stockService)
    {
        $this->orderService = $orderService;
        $this->stockService = $stockService;
    }

    /**
     * Display all pending payments.
     * Tampilkan semua pembayaran yang menunggu verifikasi
     */
    public function index()
    {
        // Get pending payments dengan order detail
        $payments = Payment::where('status', 'pending')
            ->with('order.user', 'order.orderItems')
            ->latest()
            ->paginate(10);

        // Get stats
        $stats = [
            'pending' => Payment::where('status', 'pending')->count(),
            'verified' => Payment::whereIn('status', ['settlement', 'capture', 'verified'])->count(),
            'rejected' => Payment::whereIn('status', ['expire', 'cancel', 'deny', 'failure', 'rejected'])->count(),
            'pending_amount' => Order::where('payment_status', 'unpaid')->sum('total'),
        ];

        return view('admin.payments.index', compact('payments', 'stats'));
    }

    /**
     * Show payment detail.
     * Tampilkan detail pembayaran untuk verifikasi
     */
    public function show(Payment $payment)
    {
        $payment->load('order.user', 'order.orderItems.product', 'order.shippingAddress');

        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Verify payment (approve).
     * Admin verifikasi dan approve pembayaran
     */
   public function verify(Request $request, Payment $payment)
{
    if ($payment->status !== 'pending') {
        return back()->with('error', 'Pembayaran sudah diverifikasi sebelumnya.');
    }

    try {
        $payment->update([
            'status' => 'verified',
            'verified_at' => now(),
        ]);

        $order = $payment->order;
        $order->update([
            'payment_status' => 'paid',
        ]);

        return back()->with('success', 'Pembayaran berhasil diverifikasi.');

    } catch (\Exception $e) {
        return back()->with('error', 'Error: ' . $e->getMessage());
    }
}
    public function reject(Request $request, Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return back()->with('error', 'Pembayaran sudah diverifikasi sebelumnya.');
        }

        try {
            $payment->update(['status' => 'rejected']);
            $payment->order->update(['payment_status' => 'rejected']);

            $this->stockService->restoreStockForRejection($payment->order_id);

            return back()->with('success', 'Pembayaran berhasil ditolak. Stok telah dikembalikan.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Download payment proof file.
     */
    public function downloadProof(Payment $payment)
    {
        if (!$payment->proof) {
            return back()->with('error', 'Bukti pembayaran tidak tersedia.');
        }

        $path = $payment->proof;

        if (!Storage::disk('public')->exists($path)) {
            return back()->with('error', 'File bukti pembayaran tidak ditemukan.');
        }

        return Storage::disk('public')->download(
            $path,
            'bukti-pembayaran-' . $payment->order->order_number . '.' . pathinfo($path, PATHINFO_EXTENSION)
        );
    }
    /**
     * Get payment statistics.
     */
    public function statistics()
    {
        $stats = [
            'total_pending' => Payment::where('status', 'pending')->count(),
            'total_verified' => Payment::whereIn('status', ['settlement', 'capture', 'verified'])->count(),
            'total_rejected' => Payment::whereIn('status', ['expire', 'cancel', 'deny', 'failure', 'rejected'])->count(),

            'pending_amount' => Order::where('payment_status', 'unpaid')->sum('total'),
            'verified_amount' => Order::where('payment_status', 'paid')->sum('total'),
        ];

        $paymentsByMethod = Payment::select('payment_type')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(CASE WHEN status IN ("settlement", "capture", "verified") THEN 1 ELSE 0 END) as verified')
            ->groupBy('payment_type')
            ->get();

        return view('admin.payments.statistics', compact('stats', 'paymentsByMethod'));
    }
}