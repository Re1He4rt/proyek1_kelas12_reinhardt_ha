<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Payment
 * Merepresentasikan data pembayaran dari Midtrans
 */
class Payment extends Model
{
    use HasFactory;

    /**
     * Kolom yang disesuaikan dengan struktur baru (Midtrans)
     */
    protected $fillable = [
        'order_id',
        'transaction_id',
        'payment_type',
        'gross_amount',
        'status',
        'payload',
        'proof',
        'uploaded_at',
        'verified_at',
    ];

    /**
     * Cast payload JSON string ke dalam bentuk array PHP otomatis
     */
    protected $casts = [
        'gross_amount' => 'decimal:2',
        'payload' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Mengubah format tipe pembayaran Midtrans agar lebih enak dibaca
     */
    public function getPaymentTypeLabelAttribute(): string
    {
        return match($this->payment_type) {
            'bank_transfer' => 'Transfer Bank',
            'gopay' => 'GoPay',
            'shopeepay' => 'ShopeePay',
            'qris' => 'QRIS',
            default => strtoupper(str_replace('_', ' ', $this->payment_type ?? 'Belum Dipilih')),
        };
    }

    /**
     * Mengubah status standar Midtrans ke Bahasa Indonesia
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu Pembayaran',
            'settlement', 'capture', 'verified' => 'Berhasil (Lunas)',
            'expire' => 'Kedaluwarsa',
            'cancel' => 'Dibatalkan',
            'deny', 'failure', 'rejected' => 'Ditolak/Gagal',
            default => 'Unknown',
        };
    }

    public function isSuccess(): bool
    {
        return in_array($this->status, ['settlement', 'capture', 'verified']);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}
