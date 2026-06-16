<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; //hapus kalo datanya sudah tidak dummy
use Illuminate\Database\Eloquent\Model;

class Penawaran extends Model
{   
    use HasFactory; // ini juga
    protected $table = 'penawaran';
    protected $primaryKey = 'idTawar';
    protected $fillable =[
        'idPanen',
        'idMinta',
        'Komoditas',
        'JumlahTawar',
        'HargaTawar',
        'Status',
        'Catatan',
        'Gambar'
    ];
}
