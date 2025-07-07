<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriteria';
    protected $primaryKey = 'kriteria_id';
    protected $fillable = ['sekolah_id', 'kode_kriteria', 'nama_kriteria', 'jenis'];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id', 'sekolah_id');
    }

    public function bobot()
    {
        return $this->hasOne(BobotKriteria::class, 'kriteria_id', 'kriteria_id');
    }

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class, 'kriteria_id', 'kriteria_id');
    }

    public function nilaiprestasi()
    {
        return $this->hasMany(NilaiPrestasi::class, 'kriteria_id', 'kriteria_id');
    }
}
