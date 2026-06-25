<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; //hapus kalo datanya sudah tidak dummy
use Illuminate\Database\Eloquent\Model;
use App\Models\Permintaan;

class Penawaran extends Model
{   
    use HasFactory; // ini juga
    protected $table = 'penawaran';
    protected $primaryKey = 'idTawar';
   protected $fillable =[
        'user_id', // ID Petani
        'idMinta',
        'NamaTanaman',
        'Komoditas',
        'JumlahTawar',
        'HargaTawar',
        'Status',
        'Catatan',
        'Gambar',
    ];

    public function permintaan()
    {
        return $this->belongsTo(Permintaan::class, 'idMinta', 'idPermintaan');
    }
}
