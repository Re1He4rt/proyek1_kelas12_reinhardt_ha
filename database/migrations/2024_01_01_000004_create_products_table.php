<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel products untuk menyimpan data produk buku
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Relasi ke categories (genre buku)
            $table->string('name'); // Judul buku
            $table->string('author')->nullable(); // Nama penulis buku
            $table->string('publisher')->nullable(); // Nama penerbit
            $table->integer('year')->nullable(); // Tahun terbit
            $table->string('isbn')->nullable(); // Nomor ISBN buku
            $table->decimal('price', 10, 2); // Harga buku
            $table->integer('stock')->default(0); // Jumlah stok tersedia
            $table->text('description')->nullable(); // Sinopsis atau deskripsi buku
            $table->string('image')->nullable(); // Path/nama file gambar cover buku
            $table->timestamps();
        });
    }

    /**
     * Hapus tabel products
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
