<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panen extends Model
{
    // Nama Tabel
    protected $table = 'panen';
    protected $primaryKey = 'idPanen';
    protected $fillable = [
        'Komoditas',
        'Kategori',
        'JumlahPanen',
        'TglPanen',
        'LokasiPanen',
        'Status',
        'Deskripsi'
    ];
}
