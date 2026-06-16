<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pembeli_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_toko');
            $table->string('alamat');
            $table->string('no_telepon');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pembeli_profiles');
    }
};