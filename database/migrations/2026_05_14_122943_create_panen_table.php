<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('panen', function (Blueprint $table) {
            $table->id('idPanen');
            $table->string('NamaTanaman');
            $table->string('Komoditas');
            $table->integer('JumlahPanen');
            $table->decimal('HargaPerKg', 10, 2);
            $table->date('TglPanen');
            $table->text('LokasiPanen');
            $table->string('Status');
            $table->text('Deskripsi')->nullable();
            $table->string('Gambar');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panen');
    }
};
