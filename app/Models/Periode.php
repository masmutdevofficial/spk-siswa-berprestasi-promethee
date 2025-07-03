<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;

    protected $table = 'periode';
    protected $fillable = ['tahun_ajaran'];

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class);
    }

    public function rankings()
    {
        return $this->hasMany(Ranking::class);
    }
}
