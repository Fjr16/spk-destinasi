<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryAlternatifValue extends Model
{
    use HasFactory;

    protected $fillable =  [
        'history_id',
        'alternative_id',
        'criteria_id',
        'name',
        'nilai_awal',
        'nilai_normalisasi',
        'nilai_preferensi',
    ];

    public function history(){
        return $this->belongsTo(History::class);
    }
    public function alternative(){
        return $this->belongsTo(Alternative::class);
    }
    public function criteria(){
        return $this->belongsTo(Criteria::class);
    }
}
