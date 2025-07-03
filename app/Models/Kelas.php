<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $fillable = ['sekolah_id', 'nama_kelas'];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class);
    }

    public function rankings()
    {
        return $this->hasMany(Ranking::class);
    }
}
