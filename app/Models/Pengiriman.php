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
        'id_kurir',
        'no_resi',
        'foto_resi_awal',
        'StatusPesanan',
        'catatan',
        'WaktuKirim',
        'WaktuSelesai'
    ];

    // Relasi ke tabel penawaran
    public function penawaran()
    {
        return $this->belongsTo(Penawaran::class, 'idTawar', 'idTawar');
    }

    // Relasi ke pembayaran
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'idTawar', 'idTawar');
    }

    // Relasi ke kurir (User dengan role kurir)
    public function kurir()
    {
        return $this->belongsTo(User::class, 'id_kurir', 'id');
    }

    // Relasi ke riwayat tracking
    public function tracking()
    {
        return $this->hasMany(PengirimanTracking::class, 'idPengiriman', 'idPengiriman')->orderBy('waktu_scan', 'asc');
    }
}
