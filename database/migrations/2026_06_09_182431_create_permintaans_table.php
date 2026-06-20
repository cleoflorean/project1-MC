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
        Schema::create('permintaans', function (Blueprint $table) {
            $table->id('idPermintaan'); // Sesuai dengan property $item->idPermintaan
            $table->string('NamaPembeli');
            $table->string('LokasiPembeli');
            $table->string('NamaTanaman');
            $table->string('Komoditas')->nullable(); // Menambahkan kolom Komoditas
            $table->integer('JumlahDibutuhkan');
            $table->decimal('HargaMaksimal', 15, 2); // Menggunakan decimal untuk uang
            $table->date('BatasTanggal');
            $table->string('Status')->default('Aktif'); // Default Aktif sesuai filter controller
            $table->timestamps();
        });
    }

    // public function down(): void
    // {
    //     Schema::dropIfExists('permintaans');
    // }
        // Schema::create('permintaans', function (Blueprint $table) {
        //     $table->id();
            
            // Relasi ke tabel users
            // onDelete('cascade') berarti jika user dihapus, permintaannya ikut terhapus
            // $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // $table->string('komoditas');
            // $table->integer('volume');
            // $table->integer('batas_harga');
            // $table->date('batas_akhir');
            // $table->timestamps();
      
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaans');
    }
};