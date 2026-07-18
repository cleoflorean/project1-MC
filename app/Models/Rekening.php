<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    use HasFactory;

    // 1. Beritahu Laravel nama tabel yang benar
    protected $table = 'rekenings';

    // 2. Beritahu Laravel primary key-nya (karena kita tidak pakai 'id' standar)
    protected $primaryKey = 'idRekening';

    // 3. Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'user_id',
        'NamaBank',
        'NoRekening',
        'AtasNama',
    ];

    /**
     * Relasi kebalikan (Inverse) ke tabel User.
     * Ini memungkinkan kita memanggil: $rekening->user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}