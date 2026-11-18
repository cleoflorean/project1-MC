<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Ubah enum role di users untuk menyertakan 'kurir'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('pembeli', 'petani', 'admin', 'kurir') DEFAULT 'pembeli'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('pembeli', 'petani', 'admin') DEFAULT 'pembeli'");
    }
};
