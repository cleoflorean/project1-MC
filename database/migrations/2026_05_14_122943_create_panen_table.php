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
        Schema::create('panen', function (Blueprint $table) {
            $table->id('idPanen');
            $table->string('Komoditas');
            $table->string('Kategori');
            $table->integer('JumlahPanen');
            $table->date('TglPanen');
            $table->text('LokasiPanen');
            $table->string('Status');
            $table->text('Deskripsi');
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
