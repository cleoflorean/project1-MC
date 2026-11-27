<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('kurirs', function (Blueprint $table) {
            $table->string('foto_sim')->nullable();
            $table->string('foto_ktp')->nullable();
            $table->string('foto_skck')->nullable();
            $table->string('NIK', 20)->nullable();
            $table->enum('jenis_kelamin', ['L','P'])->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('jenis_kendaraan', 50)->nullable();
        });
    }

    public function down()
    {
        Schema::table('kurirs', function (Blueprint $table) {
            $table->dropColumn(['foto_sim','foto_ktp','foto_skck','NIK','jenis_kelamin','tanggal_lahir','jenis_kendaraan']);
        });
    }
};