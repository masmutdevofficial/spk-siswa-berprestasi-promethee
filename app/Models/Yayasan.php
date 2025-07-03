<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Yayasan extends Model
{
    use HasFactory;

    protected $table = 'yayasan';
    protected $fillable = ['nama_yayasan', 'alamat', 'admin_yayasan_id'];

    public function adminyayasan()
    {
        return $this->belongsTo(AdminYayasan::class);
    }

    public function sekolahs()
    {
        return $this->hasMany(Sekolah::class);
    }
}
