<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permintaan extends Model
{
    // Pastikan user_id masuk ke dalam fillable
    protected $fillable = [
        'user_id', 
        'komoditas', 
        'volume', 
        'batas_harga', 
        'batas_akhir'
    ];

    // Setiap permintaan dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}