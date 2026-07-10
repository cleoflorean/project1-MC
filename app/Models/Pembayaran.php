<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans';
    protected $primaryKey = 'idPembayaran';

    // PERBAIKAN: Tambahkan WaktuBayar, WaktuKirim, dan WaktuSelesai ke sini
    protected $fillable = [
        'idTawar', 
        'TotalBayar', 
        'BuktiTransfer', 
        'StatusPembayaran', 
        'StatusPesanan',
        'WaktuBayar',      // <- Ditambahkan
        'WaktuKirim',      // <- Ditambahkan
        'WaktuSelesai'     // <- Ditambahkan
    ];

    // Relasi ke tabel penawaran
    public function penawaran()
    {
        return $this->belongsTo(Penawaran::class, 'idTawar', 'idTawar');
    }

    // RELASI: One-to-One ke tabel Ulasan
    public function ulasan()
    {
        return $this->hasOne(Ulasan::class, 'idPembayaran', 'idPembayaran');
    }
}