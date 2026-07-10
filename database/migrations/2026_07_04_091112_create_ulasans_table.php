<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ulasans', function (Blueprint $table) {
            $table->id('idUlasan'); // Primary Key
            
            // Relasi ke tabel pembayaran (Foreign Key)
            $table->unsignedBigInteger('idPembayaran');
            $table->foreign('idPembayaran')->references('idPembayaran')->on('pembayarans')->onDelete('cascade');
            
            // Menggunakan UNIQUE constraint agar 1 transaksi benar-benar HANYA BISA diberi 1 rating saja (Aturan ERD 1-to-1)
            $table->unique('idPembayaran'); 
            
            // Data Konten Ulasan
            $table->integer('Rating'); // Nilai 1 sampai 5
            $table->text('Ulasan')->nullable(); // Komentar tertulis dari pembeli
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasans');
    }
};