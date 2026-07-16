<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel payments untuk menyimpan data pembayaran buku
     * Setiap order punya satu payment (one-to-one)
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('transaction_id')->nullable(); // ID dari Midtrans
            $table->string('payment_type')->nullable(); // bank_transfer, gopay, shopeepay
            $table->decimal('gross_amount', 10, 2);
            $table->string('status')->default('pending'); // pending, settlement, expire, cancel
            $table->json('payload')->nullable(); // Menyimpan respon utuh dari Midtrans
            $table->timestamps();
        });
    }

    /**
     * Hapus tabel payments
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
