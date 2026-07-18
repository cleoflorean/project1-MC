<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id('idPembayaran');
            $table->unsignedBigInteger('idTawar'); // Berelasi ke Penawaran
            
            // MURNI FINANSIAL
            $table->decimal('TotalBayar',15,2);
            $table->string('BuktiTransfer',255)->nullable();
            $table->string('StatusPembayaran',15)->default('Belum Bayar');
            $table->timestamp('WaktuBayar')->nullable();
            
            // Kolom StatusPesanan, WaktuKirim, WaktuSelesai sudah DIHAPUS dari sini

            $table->timestamps();

            // Relasi
            $table->foreign('idTawar')->references('idTawar')->on('penawaran')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembayarans');
    }
};