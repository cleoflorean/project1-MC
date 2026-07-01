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
    Schema::create('pengiriman', function (Blueprint $table) {
        $table->id('idKirim'); 
        
        // Buat kolom
        $table->unsignedBigInteger('idTawar');
        
        // Definisikan relasi ke tabel penawaran
        $table->foreign('idTawar')->references('idTawar')->on('penawaran')->onDelete('cascade');
        
        $table->string('NamaPengirim');
        $table->string('NoKendaraan');
        $table->date('TanggalTiba');
        $table->date('EstimasiTiba');
        $table->text('LokasiTujuan');
        $table->string('Status');
        $table->string('BuktiPengiriman');
        $table->timestamps(); // Saya buka comment ini karena best practice tabel punya timestamp
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengiriman');
    }
};