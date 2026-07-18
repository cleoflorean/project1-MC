<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username',25)->unique(); 
            $table->string('email',100)->unique();    
            $table->string('password');
            
            // PERBAIKAN FATAL: Tambahkan role 'admin' di sini agar AdminSeeder bisa berjalan!
            $table->enum('role', ['pembeli', 'petani', 'admin'])->default('pembeli');
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('users');
    }
};