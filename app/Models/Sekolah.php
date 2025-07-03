<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $table = 'sekolah';
    protected $fillable = ['yayasan_id', 'nama_sekolah', 'alamat'];

    public function yayasan()
    {
        return $this->belongsTo(Yayasan::class);
    }

    public function adminsekolahs()
    {
        return $this->hasMany(AdminSekolah::class);
    }

    public function usergurus()
    {
        return $this->hasMany(UserGuru::class);
    }

    public function kelass()
    {
        return $this->hasMany(Kelas::class);
    }

    public function kriterias()
    {
        return $this->hasMany(Kriteria::class);
    }
}
