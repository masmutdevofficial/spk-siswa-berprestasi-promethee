<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $primaryKey = 'siswa_id';
    protected $fillable = ['kelas_id', 'nis', 'nama_siswa', 'jenis_kelamin'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'kelas_id');
    }

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class, 'siswa_id', 'siswa_id');
    }

    public function nilaiprestasi()
    {
        return $this->hasMany(NilaiPrestasi::class, 'siswa_id', 'siswa_id');
    }

    public function rankings()
    {
        return $this->hasMany(Rekomendasi::class, 'siswa_id', 'siswa_id');
    }
}
