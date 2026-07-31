<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permintaan extends Model
{
    use HasFactory;

    protected $table = 'permintaans';
    protected $primaryKey = 'idPermintaan';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'komoditas_id',
        'JumlahDibutuhkan',
        'HargaMaksimal',
        'BatasTanggal',
        'Status',
    ];

    public function komoditas()
    {
        return $this->belongsTo(Komoditas::class, 'komoditas_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Hubungkan Permintaan ke tabel Penawaran (One-to-Many)
     */
    public function penawarans()
    {
        return $this->hasMany(Penawaran::class, 'idMinta', 'idPermintaan');
    }
}