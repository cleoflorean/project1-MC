<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetaniProfile extends Model
{
    use HasFactory;

    protected $table = 'petani_profiles';

    // 1. Primary Key Anda adalah idPetani
    protected $primaryKey = 'idPetani';
    public $incrementing = true;
    protected $keyType = 'int';

    // 2. Definisi Timestamp Custom
    const CREATED_AT = 'CreateAt';
    const UPDATED_AT = 'Updated';

    // 3. Fillable (Pastikan tidak ada spasi berlebih)
    protected $fillable = [
        'id', 
        'NamaLengkap',
        'NamaKebun',
        'Alamat',
        'NoTlp',
        'Bio',
        'FotoProfile',
    ];

    // 4. Relasi ke User
    public function user()
    {
        // GANTI: Harusnya menggunakan 'id' (Foreign Key Anda), 
        // bukan 'idPetani' (Primary Key Anda)
        return $this->belongsTo(User::class, 'id', 'id');
    }
}