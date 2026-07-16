<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel orders dan order_items untuk pesanan buku
     * Orders: Data pesanan customer
     * Order Items: Detail item buku dalam pesanan
     */
    public function up(): void
    {
        // Tabel orders
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('shipping_address_id')->nullable()->constrained()->onDelete('set null');
            $table->string('order_number')->unique();
            $table->decimal('total', 10, 2);
            $table->string('snap_token')->nullable(); // Ditambahkan untuk menyimpan token Midtrans
            $table->enum('status', ['pending', 'processed', 'shipped', 'completed', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['unpaid', 'pending', 'paid', 'rejected'])->default('unpaid');
            $table->timestamps();
        });

        // Tabel order_items
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Relasi ke orders
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Buku yang dibeli
            $table->integer('qty'); // Jumlah buku
            $table->decimal('price', 10, 2); // Harga saat transaksi
            $table->decimal('subtotal', 10, 2); // Subtotal = qty × price
            $table->timestamps();
        });
    }

    /**
     * Hapus tabel order_items dan orders
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
