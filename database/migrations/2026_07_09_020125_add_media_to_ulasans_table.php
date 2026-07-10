<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('ulasans', function (Blueprint $table) {
            $table->string('MediaUlasan')->nullable()->after('Ulasan');
        });
    }
    public function down() {
        Schema::table('ulasans', function (Blueprint $table) {
            $table->dropColumn('MediaUlasan');
        });
    }
};