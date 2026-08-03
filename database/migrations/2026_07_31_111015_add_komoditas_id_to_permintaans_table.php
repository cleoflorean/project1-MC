<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permintaans', function (Blueprint $table) {
            // Cek agar aman saat deploy di Railway
            if (!Schema::hasColumn('permintaans', 'komoditas_id')) {
                $table->foreignId('komoditas_id')
                      ->nullable()
                      ->constrained('komoditas')
                      ->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('permintaans', function (Blueprint $table) {
            if (Schema::hasColumn('permintaans', 'komoditas_id')) {
                $table->dropForeign(['komoditas_id']);
                $table->dropColumn('komoditas_id');
            }
        });
    }
};