<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $table = 'semester';
    protected $primaryKey = 'semester_id';
    protected $fillable = ['nama'];

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class, 'semester_id', 'semester_id');
    }
}
