<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // Menambahkan relasi ke ID Akun
        'villa_id',
        'customer_name',
        'customer_phone',
        'check_in',
        'check_out',
        'total_price',
        'status',
        'payment_proof',
        'payment_method',
    ];

    public function villa()
    {
        return $this->belongsTo(Villa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}