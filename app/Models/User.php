<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username', 
        'email',
        'password',
        'role',     
    ];

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

    // ====================================================================
    // RELASI DATA PENGGUNA (UNIVERSAL)
    // ====================================================================

    /**
     * Relasi One-to-One ke profil universal (Biodata untuk Petani & Pembeli)
     */
    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }

    /**
     * Relasi One-to-One ke rekening universal (Untuk Admin, Petani, dan Pembeli)
     */
    public function rekening()
    {
        return $this->hasOne(Rekening::class, 'user_id', 'id');
    }


    // ====================================================================
    // RELASI TRANSAKSI
    // ====================================================================

    /**
     * Relasi One-to-Many ke permintaan (Barang yang dicari pembeli)
     */
    public function permintaans()
    {
        return $this->hasMany(Permintaan::class, 'user_id');
    }

    /**
     * Relasi One-to-Many ke penawaran (Barang yang ditawarkan petani)
     */
    public function penawarans()
    {
        return $this->hasMany(Penawaran::class, 'idPetani', 'id');
    }
}