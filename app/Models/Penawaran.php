<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penawaran extends Model
{
    protected $table = 'penwaran';
    protected $primaryKey = 'idTawar';
    protected $fillable =[
        'idPanen',
        'idMinta',
        'JumlahTawar',
        'HargaTawar',
        'Status',
        'Catatan'
    ];
}
