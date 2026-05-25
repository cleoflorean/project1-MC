<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    protected $table = 'pengiriman';
    protected $primaryKey = 'idKirim';
    protected $fillable = [
        'idTawar',
        'NamaPengirim',
        'NoKendaraan',
        'TanggalTiba',
        'EstimasiTiba',
        'LokasiTujuan',
        'Status',
        'BuktiPengiriman'
    ];
}
