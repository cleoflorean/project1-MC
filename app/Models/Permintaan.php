<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permintaan extends Model
{
    protected $table = 'permintaan';
    protected $primaryKey = 'idMinta';
    protected $fillable = [
        'NamaPembeli',
        'Komoditas',
        'JumlahButuh',
        'HargaTawar',
        'LokasiPengirim',
        'BatasTanggal',
        'Status',
        'Deskripsi',
        'Gambar'
        ];
}
