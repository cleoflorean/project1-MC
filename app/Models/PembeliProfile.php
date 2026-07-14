<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PembeliProfile extends Model {
    protected $table = 'pembeli_profiles';
    protected $primaryKey = 'idPembeli';

    protected $fillable = [
        'user_id', 'NamaLengkap', 'Alamat', 'NoTlp', 'Bio', 'FotoProfile'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}