<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengirimans', function (Blueprint $table) {
            $table->id('idPengiriman');
            $table->unsignedBigInteger('idTawar'); // Berelasi ke Penawaran
            
            // MURNI LOGISTIK / OPERASIONAL
            $table->string('StatusPesanan')->default('Menyiapkan Barang');
            $table->timestamp('WaktuKirim')->nullable();
            $table->timestamp('WaktuSelesai')->nullable();
            
            $table->timestamps();

            // Relasi
            $table->foreign('idTawar')->references('idTawar')->on('penawaran')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengirimans');
    }
};