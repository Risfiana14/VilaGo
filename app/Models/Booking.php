<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'villa_id', 'customer_name', 'customer_phone', 
        'check_in', 'check_out', 'total_price', 'status'
    ];

    public function villa()
    {
        return $table = $this->belongsTo(Villa::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}