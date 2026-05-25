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
            $table->string('Komoditas');
            $table->integer('JumlahButuh');
            $table->decimal('HargaTawar', 12, 2);
            $table->text('LokasiPengirim');
            $table->date('Deadline');
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
        Schema::dropIfExists('permintaan');
    }
};
