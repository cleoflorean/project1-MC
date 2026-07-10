<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('petani_profiles', function (Blueprint $table) {
            $table->bigIncrements('idPetani');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->string('NamaLengkap')->nullable(); 
            $table->text('Alamat')->nullable();
            $table->string('NoTlp', 20)->nullable();
            $table->text('Bio')->nullable();
            $table->string('FotoProfile')->nullable();

            // TAMBAHAN KOLOM UNTUK REKENING PETANI
            $table->string('NamaBank')->nullable();
            $table->string('NamaPemilik')->nullable();
            $table->string('NoRekening')->nullable();
            
            $table->timestamps();
        });
    }
    
    public function down(): void { 
        Schema::dropIfExists('petani_profiles'); 
    }
};