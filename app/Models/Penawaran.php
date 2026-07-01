<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penawaran extends Model
{   
    use HasFactory;
    protected $table = 'penawaran';
    protected $primaryKey = 'idTawar';
    public $timestamps = true;
    
    protected $fillable =[
        'idPetani', 'idMinta', 'NamaTanaman', 'Komoditas', 
        'JumlahTawar', 'HargaTawar', 'Status', 'Catatan', 'Gambar'
    ];

    public function permintaan()
    {
        return $this->belongsTo(Permintaan::class, 'idMinta', 'idPermintaan');
    }

    // FUNGSI INI WAJIB ADA DAN DI-SAVE!
    public function petani()
    {
        return $this->belongsTo(User::class, 'idPetani', 'id');
    }
}