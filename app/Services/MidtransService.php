<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Midtrans\Transaction;

class MidtransService
{
    public function __construct()
    {
        $this->configure();
    }

    /**
     * Konfigurasi Midtrans SDK dari config/services.php
     */
    private function configure(): void
    {
        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized  = config('services.midtrans.is_sanitized');
        Config::$is3ds        = config('services.midtrans.is_3ds');
    }

    /**
     * Generate Snap Token untuk pembayaran order
     *
     * @return string Snap token
     */
    public function generateSnapToken(Order $order): string
    {
        $address = $order->shippingAddress;

        $params = [
            'transaction_details' => [
                'order_id'     => $order->order_number,
                'gross_amount' => (float) $order->total,
            ],
            'enabled_payments' => [
                'bank_transfer',
                'gopay',
                'shopeepay',
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'phone'      => $address?->phone ?? '-',
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        Log::info("Midtrans snap token generated for order {$order->order_number}");

        return $snapToken;
    }

    /**
     * Verifikasi signature webhook dari Midtrans
     */
    public function verifyNotificationSignature(array $payload): bool
    {
        $serverKey = config('services.midtrans.server_key');

        $signature = hash('sha512',
            $payload['order_id'] .
            $payload['status_code'] .
            $payload['gross_amount'] .
            $serverKey
        );

        return hash_equals($signature, $payload['signature_key']);
    }

    /**
     * Parse status Midtrans ke payment_status lokal
     */
    public function mapPaymentStatus(string $midtransStatus): string
    {
        return match ($midtransStatus) {
            'settlement', 'capture' => 'paid',
            'pending'               => 'pending',
            'expire', 'cancel', 'deny', 'failure' => 'rejected',
            default => 'pending',
        };
    }

    /**
     * Get client key untuk frontend snap.js
     */
    public function getClientKey(): string
    {
        return config('services.midtrans.client_key');
    }

    /**
     * Cek status transaksi langsung ke Midtrans API
     * Digunakan sebagai fallback saat webhook tidak terdeliver (localhost)
     */
    public function checkTransactionStatus(string $orderNumber): ?array
    {
        try {
            $response = Transaction::status($orderNumber);

            return [
                'transaction_status' => $response['transaction_status'] ?? null,
                'transaction_id'     => $response['transaction_id'] ?? null,
                'payment_type'       => $response['payment_type'] ?? null,
                'gross_amount'       => $response['gross_amount'] ?? null,
            ];
        } catch (\Exception $e) {
            Log::warning("Midtrans API status check failed for order {$orderNumber}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Cek apakah environment production
     */
    public function isProduction(): bool
    {
        return config('services.midtrans.is_production', false);
    }
}
