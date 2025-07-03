<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminYayasan extends Authenticatable
{
    use HasFactory;

    protected $table = 'admin_yayasan';
    protected $fillable = ['username', 'email', 'password'];

    public function yayasans()
    {
        return $this->hasMany(Yayasan::class);
    }
}
