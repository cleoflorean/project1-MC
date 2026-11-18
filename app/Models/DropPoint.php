<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DropPoint extends Model
{
    use HasFactory;

    protected $table = 'drop_points';

    protected $fillable = [
        'nama_titik',
        'alamat',
        'kota',
        'penanggung_jawab',
        'telepon',
    ];

    public function trackings()
    {
        return $this->hasMany(PengirimanTracking::class, 'drop_point_id');
    }
}
