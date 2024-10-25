<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryWeightNormalization extends Model
{
    use HasFactory;

    protected $fillable =  [
        'history_id',
        'criteria_id',
        'bobot_normalisasi',
        'kriteria',
        'pembagi',
    ];

    public function history() {
        return $this->belongsTo(History::class);
    }
}
