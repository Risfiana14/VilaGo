<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'user_id',
        'villa_id',
        'rating',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function villa()
    {
        return $this->belongsTo(Villa::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Menghitung rata-rata rating
    public function averageRating()
    {
        return round($this->reviews()->avg('rating'), 1) ?? 0;
    }
}