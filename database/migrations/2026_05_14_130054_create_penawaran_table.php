<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penawaran', function (Blueprint $table) {
            $table->id('idTawar'); // Primary Key
            
            // Kolom Relasi
            $table->unsignedBigInteger('idMinta'); // Ke permintaan pembeli
            $table->unsignedBigInteger('user_id'); // Ke petani yang nawar
            
            // Kolom Data Penawaran (TIDAK ADA idPanen)
            $table->string('NamaTanaman');
            $table->string('Komoditas');
            $table->integer('JumlahTawar');
            $table->decimal('HargaTawar', 15, 2);
            $table->text('Catatan');
            $table->string('Gambar')->nullable();
            $table->string('Status')->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penawaran');
    }
};