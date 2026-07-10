<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasFactory;

    protected $table = 'ulasans';
    protected $primaryKey = 'idUlasan';

    protected $fillable = [
        'idPembayaran', 
        'Rating', 
        'Ulasan',
        'MediaUlasan'
    ];

    // Kebalikan relasi ke tabel Pembayaran
    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class, 'idPembayaran', 'idPembayaran');
    }
}