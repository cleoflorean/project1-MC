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
            $table->unsignedBigInteger('idTawar');
            
            $table->integer('TotalBayar');
            $table->string('BuktiTransfer')->nullable();
            
            // FIX: Diubah jadi string agar tidak ada lagi error Data Truncated/ENUM
            $table->string('StatusPembayaran')->default('Belum Bayar');
            $table->string('StatusPesanan')->default('Menunggu Pembayaran');
            
            // FIX: Tambahan kolom waktu yang sebelumnya tidak ada
            $table->timestamp('WaktuBayar')->nullable();
            $table->timestamp('WaktuKirim')->nullable();
            $table->timestamp('WaktuSelesai')->nullable();

            $table->timestamps();

            // Relasi tetap persis seperti yang kamu buat sebelumnya
            $table->foreign('idTawar')->references('idTawar')->on('penawaran')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembayarans');
    }
};