<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel carts dan cart_items untuk keranjang belanja buku
     * Cart: Keranjang belanja per user
     * Cart Items: Item-item buku dalam keranjang
     */
    public function up(): void
    {
        // Tabel carts
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke users (pembeli)
            $table->timestamps();
        });

        // Tabel cart_items
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->onDelete('cascade'); // Relasi ke carts
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Relasi ke products (buku)
            $table->integer('qty')->default(1); // Jumlah buku
            $table->decimal('price', 10, 2); // Harga saat ditambahkan ke cart
            $table->timestamps();
        });
    }

    /**
     * Hapus tabel cart_items dan carts
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
    }
};
