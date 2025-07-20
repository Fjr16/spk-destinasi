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
        'jenis',
        'is_include',
        'atribut',
    ];

    public function subCriterias(){
        return $this->hasMany(SubCriteria::class);
    }
    public function performanceRatings(){
        return $this->hasMany(PerformanceRating::class);
    }

    public function criteriaComparisons() {
        return $this->hasMany(CriteriaComparison::class, 'criteria_id_first', 'id');
    }
    public function criteriaWeights() {
        return $this->hasMany(CriteriaWeight::class);
    }
    public function criteriaWeightUser() {
        return $this->hasOne(CriteriaWeight::class)
        ->where('user_id', auth()->user()->id);
    }
}
