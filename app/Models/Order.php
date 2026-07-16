<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Order
 * Merepresentasikan pesanan customer
 */
class Order extends Model
{
    use HasFactory;

    /**
     * Kolom yang bisa diisi secara mass assignment
     */
    protected $fillable = [
        'user_id',
        'shipping_address_id',
        'order_number',
        'total',
        'snap_token', // TAMBAHAN: Menyimpan token Midtrans
        'status',
        'payment_status',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function shippingAddress()
    {
        return $this->belongsTo(ShippingAddress::class);
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu Diproses',
            'processed' => 'Diproses',
            'shipped' => 'Dikirim',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => 'Unknown',
        };
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return match($this->payment_status) {
            'unpaid' => 'Belum Bayar',
            'pending' => 'Menunggu Pembayaran', // Disesuaikan
            'paid' => 'Sudah Bayar',
            'rejected' => 'Batal/Kedaluwarsa', // Disesuaikan
            default => 'Unknown',
        };
    }

    public function canPay(): bool
    {
        return in_array($this->payment_status, ['unpaid', 'pending', 'rejected']);
    }

    public function canProcess(): bool
    {
        return $this->payment_status === 'paid' && $this->status === 'pending';
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public static function generateOrderNumber(): string
    {
        $date = now()->format('Ymd');
        $prefix = 'ORD-' . $date . '-';

        $lastOrder = self::where('order_number', 'like', $prefix . '%')
            ->orderByDesc('order_number')
            ->first();

        if ($lastOrder) {
            $lastSequence = (int) substr($lastOrder->order_number, -4);
            $sequence = $lastSequence + 1;
        } else {
            $sequence = 1;
        }

        return $prefix . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }
}
