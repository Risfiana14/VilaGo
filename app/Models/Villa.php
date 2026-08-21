<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Villa extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'location',
        'address',
        'price_per_night',
        'capacity',
        'description',
        'status',
        'image',
    ];

    public function facilities()
    {
        return $this->belongsToMany(Facility::class);
    }
}
