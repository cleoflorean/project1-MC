<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permintaan extends Model
{
    use HasFactory;

    // Nama tabel secara eksplisit (jika tidak mengikuti standar penamaan Laravel)
    protected $table = 'permintaans';

    // Menentukan primary key jika tidak menggunakan 'id' standar
    protected $primaryKey = 'idPermintaan';

    // Mengizinkan pengisian massal (Mass Assignment) untuk kolom-kolom ini
    protected $fillable = [
        'user_id',
        'NamaPembeli',
        'LokasiPembeli',
        'NamaTanaman',
        'Komoditas',
        'JumlahDibutuhkan',
        'HargaMaksimal',
        'BatasTanggal',
        'Status',
    ];

    // Opsional: Jika Anda ingin memformat tanggal otomatis
    protected $casts = [
        'BatasTanggal' => 'date',
        'HargaMaksimal' => 'decimal:2',
    ];
    
    // Pastikan user_id masuk ke dalam fillable
    // protected $fillable = [
    //     'user_id', 
    //     'komoditas', 
    //     'volume', 
    //     'batas_harga', 
    //     'batas_akhir'
    // ];

    // Setiap permintaan dimiliki oleh satu user
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}