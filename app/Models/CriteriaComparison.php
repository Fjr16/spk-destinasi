<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriteriaComparison extends Model
{
    use HasFactory;
    protected $casts = [
        'nilai' => 'integer',
    ];

    protected $fillable = [
        'user_id',
        'criteria_id_first',
        'criteria_id_second',
        'nilai',
    ];

    public function criteriaFirst() {
        return $this->belongsTo(Criteria::class, 'criteria_id_first', 'id');
    }
    public function criteriaSecond() {
        return $this->belongsTo(Criteria::class, 'criteria_id_second', 'id');
    }
}
