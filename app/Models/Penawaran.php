<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Penawaran extends Model
{   
    use HasFactory;
    protected $table = 'penawaran';
    protected $primaryKey = 'idTawar';
    public $timestamps = true;
    
    // Hapus 'NamaTanaman' dan 'Komoditas' dari sini
    protected $fillable =[
        'idPetani', 'idMinta', 'JumlahTawar', 'HargaTawar', 'Status', 'Catatan', 'Gambar'
    ];

    /**
     * Otomatis membatalkan penawaran Pending yang usianya sudah lebih dari 2 hari (48 jam).
     */
    public static function cleanExpired()
    {
        return self::where('Status', 'Pending')
            ->where('created_at', '<=', Carbon::now()->subDays(2))
            ->update([
                'Status' => 'Tidak Setuju',
                'Catatan' => 'Dibatalkan otomatis oleh sistem: Kedaluwarsa karena tidak ada respon dari pembeli dalam 2x24 jam.'
            ]);
    }

    public function permintaan()
    {
        return $this->belongsTo(Permintaan::class, 'idMinta', 'idPermintaan');
    }

    public function petani()
    {
        return $this->belongsTo(User::class, 'idPetani', 'id');
    }
}