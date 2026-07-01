<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Permintaan;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username', // Mengaktifkan kolom username agar bisa disimpan
        'email',
        'password',
        'role',     // Mengaktifkan kolom role agar bisa disimpan
    ];

    // Relasi One-to-One ke profil pembeli
    public function pembeliProfile()
    {
        return $this->hasOne(PembeliProfile::class);
    }

    public function petaniProfile()
{
    // Parameter pertama: Nama kolom foreign key di tabel petani_profiles (user_id)
    // Parameter kedua: Nama kolom primary key di tabel users (id)
    return $this->hasOne(PetaniProfile::class, 'user_id', 'id');
}

    // Relasi One-to-Many ke permintaan
    public function permintaans()
    {
        return $this->hasMany(Permintaan::class, 'user_id');
    }

    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}