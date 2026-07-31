<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komoditas extends Model
{
    use HasFactory;

    protected $table = 'komoditas';

    protected $fillable = [
        'namatanaman',
        'komoditas',
    ];

    public function permintaans()
    {
        return $this->hasMany(Permintaan::class, 'komoditas_id', 'id');
    }
}
