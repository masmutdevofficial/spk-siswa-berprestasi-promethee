<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $table = 'sekolah';
    protected $primaryKey = 'sekolah_id';
    protected $fillable = ['yayasan_id', 'nama_sekolah', 'alamat'];

    public function yayasan()
    {
        return $this->belongsTo(Yayasan::class, 'yayasan_id', 'yayasan_id');
    }

    public function adminSekolahs()
    {
        return $this->hasMany(AdminSekolah::class, 'sekolah_id', 'sekolah_id');
    }

    public function userGurus()
    {
        return $this->hasMany(UserGuru::class, 'sekolah_id', 'sekolah_id');
    }

    public function kelass()
    {
        return $this->hasMany(Kelas::class, 'sekolah_id', 'sekolah_id');
    }

    public function kriterias()
    {
        return $this->hasMany(Kriteria::class, 'sekolah_id', 'sekolah_id');
    }
}
