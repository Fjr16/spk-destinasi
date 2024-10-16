<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'deskripsi',
        'alamat',
        'harga',
        'maps_lokasi',
        'foto',
        'kategori',
        'rating',
        'jumlah_fasilitas',
        'status',
    ];
}
