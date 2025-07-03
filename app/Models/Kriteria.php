<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriteria';
    protected $fillable = ['sekolah_id', 'kode_kriteria', 'nama_kriteria', 'jenis'];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function bobotkriterias()
    {
        return $this->hasMany(BobotKriteria::class);
    }

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class);
    }
}
