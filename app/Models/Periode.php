<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;

    protected $table = 'periode';
    protected $primaryKey = 'periode_id';
    protected $fillable = ['tahun_ajaran'];

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class, 'periode_id', 'periode_id');
    }

    public function rekomendasis()
    {
        return $this->hasMany(Rekomendasi::class, 'periode_id', 'periode_id');
    }
}
