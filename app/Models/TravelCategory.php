<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function alternative() {
        return $this->hasMany(Alternative::class);
    }
}