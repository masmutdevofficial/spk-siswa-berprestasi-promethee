<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $primaryKey = 'kelas_id';
    protected $fillable = ['sekolah_id', 'nama_kelas'];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id', 'sekolah_id');
    }

    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'kelas_id', 'kelas_id');
    }

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class, 'kelas_id', 'kelas_id');
    }

    public function rankings()
    {
        return $this->hasMany(Ranking::class, 'kelas_id', 'kelas_id');
    }
}
