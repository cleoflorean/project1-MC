<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('petani_profiles', function (Blueprint $table) {
            $table->bigIncrements('idPetani');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->string('NamaLengkap')->nullable(); // HANYA NAMA LENGKAP
            $table->text('Alamat')->nullable();
            $table->string('NoTlp', 20)->nullable();
            $table->text('Bio')->nullable();
            $table->string('FotoProfile')->nullable();
            
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('petani_profiles'); }
};