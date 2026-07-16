<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel stock_ins untuk pencatatan buku masuk (dari penerbit)
     */
    public function up(): void
    {
        Schema::create('stock_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Relasi ke products (buku)
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('set null'); // Penerbit bisa null
            $table->date('tanggal_masuk'); // Tanggal buku masuk gudang
            $table->integer('qty'); // Jumlah buku masuk
            $table->text('keterangan')->nullable(); // Catatan tambahan
            $table->timestamps();
        });
    }

    /**
     * Hapus tabel stock_ins
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_ins');
    }
};
