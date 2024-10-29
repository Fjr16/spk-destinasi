<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'travel_category_id',
        'deskripsi',
        'alamat',
        'harga',
        'maps_lokasi',
        'foto',
        'rating',
        'fasilitas',
        'aksesibilitas',
        'status',
    ];

    public function travelCategory(){
        return $this->belongsTo(TravelCategory::class);
    }
    public function performanceRatings(){
        return $this->hasMany(PerformanceRating::class);
    }
}
