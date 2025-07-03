<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Yayasan extends Model
{
    use HasFactory;

    protected $table = 'yayasan';
    protected $primaryKey = 'yayasan_id';
    protected $fillable = ['nama_yayasan', 'alamat', 'admin_yayasan_id'];

    public function adminyayasan()
    {
        return $this->belongsTo(AdminYayasan::class, 'admin_yayasan_id', 'admin_yayasan_id');
    }

    public function sekolahs()
    {
        return $this->hasMany(Sekolah::class);
    }
}
