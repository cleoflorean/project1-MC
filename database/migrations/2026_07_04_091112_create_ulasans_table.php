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
            
            // PERBAIKAN: Relasi ke tabel penawaran (idTawar), bukan pembayaran
            $table->unsignedBigInteger('idTawar');
            $table->foreign('idTawar')->references('idTawar')->on('penawaran')->onDelete('cascade');
            
            // 1 Deal/Order (Penawaran) HANYA BISA diberi 1 rating
            $table->unique('idTawar'); 
            
            // Data Konten Ulasan
            $table->tinyInteger('Rating')->unsigned(); 
            $table->text('Ulasan')->nullable(); 
            $table->string('MediaUlasan',255)->nullable(); // Langsung digabung ke sini
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasans');
    }
};