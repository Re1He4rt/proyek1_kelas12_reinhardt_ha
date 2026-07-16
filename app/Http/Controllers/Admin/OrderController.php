<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

/**
 * OrderController (Admin)
 * Controller untuk admin mengelola pesanan
 */
class OrderController extends Controller
{
    /**
     * List semua pesanan
     */
    public function index()
    {
        $orders = Order::with(['user', 'payment'])
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Detail pesanan
     */
    public function show(Order $order)
    {
        $order->load([
            'user',
            'shippingAddress',
            'orderItems.product',
            'payment'
        ]);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update status order
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:processed,shipped,completed,cancelled',
        ]);

        /*
        |--------------------------------------------------------------------------
        | VALIDASI PEMBAYARAN
        |--------------------------------------------------------------------------
        */

        if (
            $order->payment_status !== 'paid' &&
            $validated['status'] !== 'cancelled'
        ) {
            return back()->with(
                'error',
                'Pesanan belum dibayar / diverifikasi.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FLOW STATUS
        |--------------------------------------------------------------------------
        */

        $statusFlow = [

            'pending' => [
                'processed',
                'cancelled'
            ],

            'processed' => [
                'shipped'
            ],

            'shipped' => [
                'completed'
            ],

            'completed' => [],

            'cancelled' => [],

        ];

        $currentStatus = $order->status;
        $newStatus = $validated['status'];

        if (
            !in_array(
                $newStatus,
                $statusFlow[$currentStatus] ?? []
            )
        ) {
            return back()->with(
                'error',
                "Tidak bisa mengubah status dari {$currentStatus} ke {$newStatus}"
            );
        }

        $order->update([
            'status' => $newStatus
        ]);

        return back()->with(
            'success',
            'Status order berhasil diupdate.'
        );
    }

    /**
     * Verifikasi pembayaran
     */
    public function verifyPayment(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:verified,rejected',
        ]);

        if (!$order->payment) {
            return back()->with('error', 'Data pembayaran tidak ditemukan.');
        }

        if ($order->payment->status !== 'pending') {
            return back()->with('error', 'Pembayaran sudah diverifikasi sebelumnya.');
        }

        $payment = $order->payment;

        if ($validated['status'] === 'verified') {
            $payment->update(['status' => 'verified']);
            $order->update(['payment_status' => 'paid']);

            return back()->with('success', 'Pembayaran berhasil diverifikasi.');
        }

        $payment->update(['status' => 'rejected']);
        $order->update(['payment_status' => 'rejected']);

        return back()->with('success', 'Pembayaran berhasil ditolak.');
    }
}
