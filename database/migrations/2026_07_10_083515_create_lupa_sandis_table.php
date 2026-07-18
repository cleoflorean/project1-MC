<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lupa_sandis', function (Blueprint $table) {
            $table->id('idLupaSandi');
            $table->unsignedBigInteger('user_id');
            
            // Kolom no_whatsapp DIHAPUS karena kita akan ambil dari profil
            $table->string('password_sementara',10)->nullable();
            $table->enum('status', ['Menunggu', 'Selesai'])->default('Menunggu');
            
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lupa_sandis');
    }
};