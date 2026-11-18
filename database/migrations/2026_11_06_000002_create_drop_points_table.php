<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('drop_points', function (Blueprint $table) {
            $table->id();
            $table->string('nama_titik', 100);
            $table->text('alamat');
            $table->string('kota', 50);
            $table->string('penanggung_jawab', 100)->nullable();
            $table->string('telepon', 25)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drop_points');
    }
};
