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
        Schema::table('permintaans', function (Blueprint $table) {
            $table->foreignId('komoditas_id')->nullable()->constrained('komoditas')->onDelete('cascade');
            $table->string('namatanaman', 30)->nullable()->change();
            $table->string('komoditas', 20)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permintaans', function (Blueprint $table) {
            $table->dropForeign(['komoditas_id']);
            $table->dropColumn('komoditas_id');
        });
    }
};
