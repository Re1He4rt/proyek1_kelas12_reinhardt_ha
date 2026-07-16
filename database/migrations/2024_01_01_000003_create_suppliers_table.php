<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel suppliers untuk menyimpan data penerbit/pemasok buku
     */
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama penerbit (contoh: Gramedia, Erlangga, dll)
            $table->string('phone')->nullable(); // Nomor telepon penerbit
            $table->text('address')->nullable(); // Alamat penerbit
            $table->timestamps();
        });
    }

    /**
     * Hapus tabel suppliers
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
