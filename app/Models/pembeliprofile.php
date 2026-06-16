<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembeliProfile extends Model
{
    use HasFactory;

    // Pastikan nama tabel sesuai
    protected $table = 'pembeli_profiles';

    protected $fillable = [
        'user_id',
        'nama_toko',
        'alamat',
        'no_telepon',
    ];

    // Relasi balik ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}