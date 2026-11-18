<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengiriman_trackings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idPengiriman');
            $table->unsignedBigInteger('drop_point_id')->nullable();
            $table->string('status_log', 150);
            $table->text('catatan')->nullable();
            $table->string('foto_bukti', 255)->nullable();
            $table->timestamp('waktu_scan')->useCurrent();
            $table->timestamps();

            $table->foreign('idPengiriman')->references('idPengiriman')->on('pengirimans')->onDelete('cascade');
            $table->foreign('drop_point_id')->references('id')->on('drop_points')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengiriman_trackings');
    }
};
