<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::table('permintaans', function (Blueprint $table) {
        if (!Schema::hasColumn('permintaans', 'komoditas_id')) {
            $table->foreignId('komoditas_id')->nullable()->constrained('komoditas')->onDelete('cascade');
        }
        if (!Schema::hasColumn('permintaans', 'namatanaman')) {
            $table->string('namatanaman', 30)->nullable();
        }
        if (!Schema::hasColumn('permintaans', 'komoditas')) {
            $table->string('komoditas', 20)->nullable();
        }
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permintaans', function (Blueprint $table) {
            $table->dropForeign(['komoditas_id']);
            
            // Tambahkan kolom namatanaman dan komoditas di sini 
            // agar ikut terhapus jika menjalankan php artisan migrate:rollback
            $table->dropColumn(['komoditas_id', 'namatanaman', 'komoditas']);
        });
    }
};