<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('rekenings', function (Blueprint $table) {
            $table->id('idRekening');
            
            // Relasi ke tabel users (Bisa untuk Admin, Petani, atau Pembeli)
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Boleh di-set unique jika 1 user hanya boleh punya 1 rekening utama
            $table->unique('user_id');
            
            // Data Bank
            $table->string('NamaBank'); // cth: BCA, BRI, Mandiri
            $table->string('NoRekening');
            $table->string('AtasNama');
            
            $table->timestamps();
        });
    }
    public function down() { Schema::dropIfExists('rekenings'); }
};