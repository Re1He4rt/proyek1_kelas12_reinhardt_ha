<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel shipping_addresses untuk menyimpan alamat pengiriman customer
     * Satu customer bisa punya banyak alamat pengiriman buku
     */
    public function up(): void
    {
        Schema::create('shipping_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke users (pembeli buku)
            $table->string('recipient_name'); // Nama penerima buku
            $table->string('phone'); // Nomor HP penerima
            $table->text('address'); // Alamat lengkap pengiriman
            $table->string('city'); // Kota/Kabupaten
            $table->string('province'); // Provinsi
            $table->string('postal_code'); // Kode pos
            $table->timestamps();
        });
    }

    /**
     * Hapus tabel shipping_addresses
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_addresses');
    }
};
