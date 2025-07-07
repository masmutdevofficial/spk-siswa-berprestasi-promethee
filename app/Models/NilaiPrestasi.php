<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiPrestasi extends Model
{
    use HasFactory;

    protected $table = 'nilai_prestasi';
    protected $primaryKey = 'nilai_prestasi_id';
    protected $fillable = ['siswa_id', 'kelas_id', 'kriteria_id', 'periode_id', 'nilai_kriteria'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'siswa_id');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id', 'kriteria_id');
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id', 'periode_id');
    }

}
