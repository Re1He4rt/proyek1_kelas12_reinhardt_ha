<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel stock_outs untuk pencatatan buku keluar (non-penjualan)
     * Buku keluar karena: rusak, hilang, kadaluarsa (buku lama), dll
     */
    public function up(): void
    {
        Schema::create('stock_outs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Relasi ke products (buku)
            $table->date('tanggal_keluar'); // Tanggal buku keluar
            $table->integer('qty'); // Jumlah buku keluar
            $table->enum('alasan', ['rusak', 'hilang', 'kadaluarsa', 'lainnya'])->default('lainnya'); // Alasan keluar
            $table->text('keterangan')->nullable(); // Catatan tambahan
            $table->timestamps();
        });
    }

    /**
     * Hapus tabel stock_outs
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_outs');
    }
};
