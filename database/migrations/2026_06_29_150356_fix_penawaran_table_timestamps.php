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
        Schema::table('penawaran', function (Blueprint $table) {
        // Karena kolom sudah ada di database, kita tidak perlu menambahkan lagi.
        // Cukup pastikan Laravel tahu bahwa tabel ini menggunakan timestamps.
        // Jika Anda ingin memastikan, gunakan perintah berikut (hati-hati):
        
            if (!Schema::hasColumn('penawaran', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('penawaran', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
};
