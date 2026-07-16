<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('proof')->nullable()->after('payload');
            $table->timestamp('uploaded_at')->nullable()->after('proof');
            $table->timestamp('verified_at')->nullable()->after('uploaded_at');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['proof', 'uploaded_at', 'verified_at']);
        });
    }
};
