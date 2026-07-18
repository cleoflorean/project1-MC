<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;

    protected $table = 'pengirimans';
    protected $primaryKey = 'idPengiriman';

    // Murni urusan logistik kurir
    protected $fillable = [
        'idTawar', 
        'StatusPesanan',
        'WaktuKirim',      
        'WaktuSelesai'     
    ];

    // Relasi ke tabel penawaran
    public function penawaran()
    {
        return $this->belongsTo(Penawaran::class, 'idTawar', 'idTawar');
    }
}