<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'alternative_id',
        'criteria_id',
        'sub_criteria_id',
    ];

    public function alternative() {
        return $this->belongsTo(Alternative::class);
    }
    public function criteria() {
        return $this->belongsTo(Criteria::class);
    }
    public function subCriteria() {
        return $this->belongsTo(SubCriteria::class);
    }
}
