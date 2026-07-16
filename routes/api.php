<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Order;
use App\Models\Payment;
use App\Services\MidtransService;

/**
 * Midtrans Webhook (Notification Handler)
 *
 * Midtrans akan POST ke route ini saat status pembayaran berubah.
 * Route ini TIDAK memerlukan auth middleware (dipanggil oleh server Midtrans).
 *
 * Catatan: Untuk production, pertimbangkan untuk menambahkan
 * validasi IP whitelist Midtrans atau custom header.
 */
Route::post('/midtrans-webhook', function (Request $request) {
    $midtransService = app(MidtransService::class);

    // 1. Validasi signature key dari Midtrans
    if (!$midtransService->verifyNotificationSignature($request->all())) {
        \Log::warning('Midtrans webhook: Invalid signature', [
            'order_id' => $request->order_id ?? 'unknown',
        ]);

        return response()->json(['status' => 'error', 'message' => 'Invalid signature'], 403);
    }

    // 2. Cari order berdasarkan order_number
    $order = Order::where('order_number', $request->order_id)->first();

    if (!$order) {
        \Log::warning('Midtrans webhook: Order not found', [
            'order_id' => $request->order_id,
        ]);

        return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
    }

    // 3. Update payment record
    $payment = Payment::where('order_id', $order->id)->first();

    if ($payment) {
        $payment->update([
            'transaction_id' => $request->transaction_id,
            'payment_type'   => $request->payment_type,
            'status'         => $request->transaction_status,
            'payload'        => $request->all(),
        ]);
    }

    // 4. Map dan update order payment_status
    $newStatus = $midtransService->mapPaymentStatus($request->transaction_status);

    $order->update(['payment_status' => $newStatus]);

    \Log::info("Midtrans webhook: Order {$order->order_number} updated", [
        'midtrans_status' => $request->transaction_status,
        'new_status'      => $newStatus,
    ]);

    return response()->json(['status' => 'success']);
});
