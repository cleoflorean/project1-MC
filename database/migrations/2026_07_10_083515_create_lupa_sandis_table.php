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
        Schema::create('lupa_sandis', function (Blueprint $table) {
            // 1. Primary Key disesuaikan dengan yang ada di Model
            $table->id('idLupaSandi');
            
            // 2. Foreign Key untuk menghubungkan dengan tabel users
            $table->unsignedBigInteger('user_id');
            
            // 3. Kolom data yang dibutuhkan
            $table->string('no_whatsapp');
            $table->string('password_sementara')->nullable();
            $table->enum('status', ['Menunggu', 'Selesai'])->default('Menunggu');
            
            // 4. Timestamps (created_at dan updated_at)
            $table->timestamps();

            // 5. Deklarasi Relasi Foreign Key (Agar RDBMS-nya ketat dan aman)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lupa_sandis');
    }
};