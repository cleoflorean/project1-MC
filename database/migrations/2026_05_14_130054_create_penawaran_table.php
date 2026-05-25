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
        Schema::create('penawaran', function (Blueprint $table) {
            $table->id('idTawar');
            $table->integer('idPanen');
            $table->integer('idMinta');
            $table->integer('JumlahTawar');
            $table->decimal('HargaTawar', 12, 2);
            $table->string('Status');
            $table->text('Catatan');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penawaran');
    }
};
