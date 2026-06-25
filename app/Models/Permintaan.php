<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permintaan extends Model
{
    use HasFactory;

    protected $table = 'permintaans';
    protected $primaryKey = 'idPermintaan';

    protected $fillable = [
        'user_id',
        'NamaTanaman',
        'Komoditas',
        'JumlahDibutuhkan',
        'HargaMaksimal',
        'BatasTanggal',
        'Status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}