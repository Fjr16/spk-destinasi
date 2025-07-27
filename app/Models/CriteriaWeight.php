<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriteriaWeight extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'criteria_id',
        'total',
        'bobot',
    ];


    public function criteria(){
        return $this->belongsTo(Criteria::class);
    }
}
