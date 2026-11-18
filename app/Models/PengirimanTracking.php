<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengirimanTracking extends Model
{
    use HasFactory;

    protected $table = 'pengiriman_trackings';

    protected $fillable = [
        'idPengiriman',
        'drop_point_id',
        'status_log',
        'catatan',
        'foto_bukti',
        'waktu_scan',
    ];

    protected $casts = [
        'waktu_scan' => 'datetime',
    ];

    public function pengiriman()
    {
        return $this->belongsTo(Pengiriman::class, 'idPengiriman', 'idPengiriman');
    }

    public function dropPoint()
    {
        return $this->belongsTo(DropPoint::class, 'drop_point_id');
    }
}
