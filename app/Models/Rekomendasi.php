<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekomendasi extends Model
{
    use HasFactory;

    protected $table = 'rekomendasi';
    protected $primaryKey = 'rekomendasi_id';
    protected $fillable = ['siswa_id', 'kelas_id', 'periode_id', 'net_flow', 'ranking'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'siswa_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'kelas_id');
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id', 'periode_id');
    }
}
