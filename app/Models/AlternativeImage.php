<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlternativeImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'alternative_id',
        'img_name',
        'img_path'
    ];

    public function alternative(){
        return $this->belongsTo(Alternative::class);
    }
}
