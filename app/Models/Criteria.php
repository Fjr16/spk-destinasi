<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'name',
        'tipe',
        'bobot',
        'atribut',
        'is_include',
    ];

    public function subCriterias(){
        return $this->hasMany(SubCriteria::class);
    }
    public function performanceRatings(){
        return $this->hasMany(PerformanceRating::class);
    }
}
