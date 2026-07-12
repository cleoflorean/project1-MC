<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('komplains', function (Blueprint $table) {
            $table->id('idKomplain');
            $table->unsignedBigInteger('user_id'); // Siapa yang komplain
            $table->unsignedBigInteger('idPembayaran'); // Transaksi mana yang tidak sampai
            $table->string('no_whatsapp');
            $table->text('alasan_komplain');
            $table->string('bukti_pendukung')->nullable(); // Foto keadaan lapangan/resi
            $table->enum('status', ['Menunggu', 'Diproses', 'Selesai', 'Ditolak'])->default('Menunggu');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();

            // RDBMS Constraint - Mengunci keterikatan ke tabel Users & Pembayarans
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idPembayaran')->references('idPembayaran')->on('pembayarans')->onDelete('cascade');
        });
    }
    public function down(): void { Schema::dropIfExists('komplains'); }
};