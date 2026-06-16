<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permintaan extends Model
{
    // Mengizinkan kolom-kolom ini diisi massal
    protected $fillable = ['komoditas', 'volume', 'batas_harga', 'batas_akhir'];
}

