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
            $table->id('idKirim'); // Ini tetap dibiarkan sebagai Primary Key
            $table->unsignedBigInteger('idTawar'); // <-- Ubah baris ini
            $table->string('NamaPengirim');
            $table->string('NoKendaraan');
            $table->date('TanggalTiba');
            $table->date('EstimasiTiba');
            $table->text('LokasiTujuan');
            $table->string('Status');
            $table->string('BuktiPengiriman');
            // $table->timestamps();
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