<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans';
    protected $primaryKey = 'idPembayaran';

    protected $fillable = [
        'idTawar', 
        'TotalBayar', 
        'BuktiTransfer', 
        'StatusPembayaran', 
        'WaktuBayar'
    ];

    // Relasi ke tabel penawaran
    public function penawaran()
    {
        return $this->belongsTo(Penawaran::class, 'idTawar', 'idTawar');
    }
    
    // INI ADALAH KODE YANG BIKIN ERROR-NYA HILANG
    public function ulasan()
    {
        return $this->hasOne(Ulasan::class, 'idTawar', 'idTawar');
    }
    public function pengiriman()
{
    // Menyambungkan pembayaran dan pengiriman lewat idTawar
    return $this->hasOne(Pengiriman::class, 'idTawar', 'idTawar');
}
}