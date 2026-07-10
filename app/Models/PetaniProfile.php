<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PetaniProfile extends Model {
    protected $table = 'petani_profiles';
    protected $primaryKey = 'idPetani';

    protected $fillable = [
        'user_id', 'NamaLengkap', 'Alamat', 'NoTlp', 'Bio', 'FotoProfile',
        'NamaBank', 'NamaPemilik', 'NoRekening' // Tambahkan ini
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}