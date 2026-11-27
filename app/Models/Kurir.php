<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    use HasFactory;

    protected $table = 'kurirs';
    protected $primaryKey = 'idKurir';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'NamaLengkap',
        'NoWhatsApp',
        'Alamat',
        'Bio',
        'FotoProfil',
        'foto_sim',
        'foto_ktp',
        'foto_skck',
        'NIK',
        'jenis_kelamin',
        'tanggal_lahir',
        'jenis_kendaraan',
    ];
}
