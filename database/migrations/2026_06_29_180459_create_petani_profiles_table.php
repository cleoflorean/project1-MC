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
        Schema::create('petani_profiles', function (Blueprint $table) {
            $table->unsignedInteger('idPetani'); 
            $table->primary('idPetani'); 

            $table->unsignedInteger('id'); 
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');

            $table->string('NamaLengkap', 40);
            $table->string('NamaKebun', 40)->nullable();
            $table->text('Alamat');
            $table->string('NoTlp', 20);
            $table->text('Bio')->nullable();
            $table->string('FotoProfile', 255)->nullable();
            $table->timestamp('CreateAt')->nullable();
            $table->timestamp('Updated')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petani_profiles');
    }
};
