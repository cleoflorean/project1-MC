<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    // 1. Beritahu Laravel nama tabel yang benar
    protected $table = 'profiles';

    // 2. Beritahu Laravel primary key-nya karena kita menggunakan 'idProfile'
    protected $primaryKey = 'idProfile';

    // 3. Tentukan kolom mana saja yang boleh diisi datanya (Mass Assignment)
    protected $fillable = [
        'user_id',
        'NamaLengkap',
        'NoWhatsApp',
        'Alamat',
        'FotoProfil'
    ];

    /**
     * Relasi ke model User (One-to-One Inverse)
     * Profil ini milik satu User tertentu.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}