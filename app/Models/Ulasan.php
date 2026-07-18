<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasFactory;

    protected $table = 'ulasans';
    protected $primaryKey = 'idUlasan';

    // PERBAIKAN: idPembayaran diganti jadi idTawar
    protected $fillable = [
        'idTawar', 
        'Rating', 
        'Ulasan',
        'MediaUlasan'
    ];

    // PERBAIKAN: Kebalikan relasi mengarah ke Penawaran, bukan Pembayaran
    public function penawaran()
    {
        return $this->belongsTo(Penawaran::class, 'idTawar', 'idTawar');
    }
}