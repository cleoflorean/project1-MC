<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pengirimans', function (Blueprint $table) {
            $table->unsignedBigInteger('id_kurir')->nullable()->after('idTawar');
            $table->string('no_resi', 50)->nullable()->unique()->after('id_kurir');
            $table->string('foto_resi_awal')->nullable()->after('no_resi');
            $table->text('catatan')->nullable()->after('StatusPesanan');

            $table->foreign('id_kurir')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('pengirimans', function (Blueprint $table) {
            $table->dropForeign(['id_kurir']);
            $table->dropColumn(['id_kurir', 'no_resi', 'foto_resi_awal', 'catatan']);
        });
    }
};
