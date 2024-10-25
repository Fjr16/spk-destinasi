<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'lokasi',
    ];

    public function historyWeightNormalizations(){
        return $this->hasMany(HistoryWeightNormalization::class);
    }
    public function historyAlternatifValues(){
        return $this->hasMany(HistoryAlternatifValue::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
