<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminSekolah extends Authenticatable
{
    use HasFactory;

    protected $table = 'admin_sekolah';
    protected $primaryKey = 'admin_sekolah_id';
    protected $fillable = ['username', 'email', 'password', 'sekolah_id'];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id', 'sekolah_id');
    }
}
