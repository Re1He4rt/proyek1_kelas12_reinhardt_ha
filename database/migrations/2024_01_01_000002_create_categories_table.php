<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel categories untuk menyimpan data genre/kategori buku
     * Contoh: Fiksi, Non-Fiksi, Novel, Pengembangan Diri, dll.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama genre/kategori buku
            $table->text('description')->nullable(); // Deskripsi genre buku
            $table->enum('status', ['active', 'inactive'])->default('active'); // Status aktif/tidak
            $table->timestamps();
        });
    }

    /**
     * Hapus tabel categories
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
