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
        Schema::create('permintaan', function (Blueprint $table) {
            $table->id('idMinta');
            $table->string('NamaPembeli');
            $table->string('NamaTanaman');
            $table->string('Komoditas');
            $table->integer('JumlahButuh');
            $table->decimal('HargaTawar', 12, 2);
            $table->text('LokasiPembeli');
            $table->date('BatasTanggal');
            $table->string('Status', ['Aktif', 'Selesai'])->default('Aktif');
            $table->text('Deskripsi');
            $table->string('Gambar');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan');
    }
};
