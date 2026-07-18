<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('penawaran', function (Blueprint $table) {
            $table->id('idTawar');
            
            // Relasi ke tabel permintaans dan users
            $table->unsignedBigInteger('idMinta'); 
            $table->unsignedBigInteger('idPetani'); 
            $table->foreign('idMinta')->references('idPermintaan')->on('permintaans')->onDelete('cascade');
            $table->foreign('idPetani')->references('id')->on('users')->onDelete('cascade');
            
            $table->integer('JumlahTawar');
            $table->decimal('HargaTawar', 15, 2);
            $table->text('Catatan')->nullable();
            $table->string('Gambar')->nullable();
            $table->enum('Status', ['Pending', 'Setuju', 'Tidak Setuju'])->default('Pending');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('penawaran'); }
};