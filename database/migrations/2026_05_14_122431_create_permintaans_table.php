<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('permintaans', function (Blueprint $table) {
            $table->id('idPermintaan');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('NamaTanaman');
            $table->string('Komoditas')->nullable();
            $table->integer('JumlahDibutuhkan');
            $table->decimal('HargaMaksimal', 15, 2);
            $table->date('BatasTanggal');
            $table->string('Status')->default('Aktif');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('permintaans'); }
};