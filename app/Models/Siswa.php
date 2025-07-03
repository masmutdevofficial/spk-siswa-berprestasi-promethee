<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $fillable = ['kelas_id', 'nis', 'nama_siswa', 'jenis_kelamin'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
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
