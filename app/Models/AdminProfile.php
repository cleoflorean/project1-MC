<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminProfile extends Model
{
    protected $table = 'admin_profiles';
    protected $primaryKey = 'idAdmin';

    protected $fillable = [
        'user_id', 'NamaLengkap', 'NamaBank', 'NamaPemilik', 'NoRekening'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}