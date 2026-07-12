<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LupaSandi extends Model {
    use HasFactory;
    protected $table = 'lupa_sandis';
    protected $primaryKey = 'idLupaSandi';
    protected $fillable = ['user_id', 'no_whatsapp', 'password_sementara', 'status'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}