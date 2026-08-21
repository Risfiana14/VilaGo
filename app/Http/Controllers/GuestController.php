<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil data transaksi booking
        $query = Booking::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('customer_name', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_phone', 'like', '%' . $request->search . '%');
            });
        }

        // Pengelompokan berdasarkan nomor HP tamu untuk mendapatkan rekap unik
        $guests = $query->latest()
            ->get()
            ->groupBy('customer_phone')
            ->map(function ($bookings) {
                return (object) [
                    'customer_name'  => $bookings->first()->customer_name,
                    'customer_phone' => $bookings->first()->customer_phone,
                    'total_bookings' => $bookings->count(),
                    'total_spent'    => $bookings->where('status', 'completed')->sum('total_price'),
                    'last_booking'   => $bookings->first()->created_at,
                ];
            });

        return view('guests.index', compact('guests'));
    }
}