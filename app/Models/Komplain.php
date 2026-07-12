<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komplain extends Model {
    use HasFactory;
    protected $table = 'komplains';
    protected $primaryKey = 'idKomplain';
    protected $fillable = ['user_id', 'idPembayaran', 'no_whatsapp', 'alasan_komplain', 'bukti_pendukung', 'status', 'catatan_admin'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function pembayaran() {
        return $this->belongsTo(Pembayaran::class, 'idPembayaran', 'idPembayaran');
    }
}