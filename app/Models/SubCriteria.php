<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCriteria extends Model
{
    use HasFactory;

    protected $fillable = [
        'criteria_id',
        'label',
        'min_value',
        'max_value',
        'bobot',
    ];

    // protected $casts = [
    //     'bobot' => 'integer',
    //     'min_value' => 'decimal',
    //     'max_value' => 'decimal',
    // ];
    public function getFormattedMinValueAttribute()
    {
        return $this->reformatValue($this->min_value);
    }

    public function getFormattedMaxValueAttribute()
    {
        return $this->reformatValue($this->max_value);
    }

    public function reformatValue($value){
        if(!is_numeric($value)) return $value;

        if(fmod($value,1) == 0.0){
            return (int) $value;
        }

        return $value;
    }

    public function criteria() {
        return $this->belongsTo(Criteria::class);        
    }
}
