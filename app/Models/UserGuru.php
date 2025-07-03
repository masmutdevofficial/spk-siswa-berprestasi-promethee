<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserGuru extends Authenticatable
{
    use HasFactory;

    protected $table = 'user_guru';
    protected $fillable = ['sekolah_id', 'username', 'email', 'password', 'nama'];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}
