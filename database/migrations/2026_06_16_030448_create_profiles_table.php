<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id('idProfile');
            $table->unsignedBigInteger('user_id');
            
            // Biodata untuk Petani dan Pembeli
            $table->string('NamaLengkap',60);
            $table->string('NoWhatsApp',17)->nullable();
            $table->text('Alamat')->nullable();
            $table->text('Bio')->nullable();
            $table->string('FotoProfil',255)->nullable();
            
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique('user_id');
        });
    }
    public function down() { Schema::dropIfExists('profiles'); }
};