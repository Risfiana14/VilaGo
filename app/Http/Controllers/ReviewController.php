<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $bookingId)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ], [
            'rating.required'  => 'Silakan beri nilai bintang (1 - 5).',
            'comment.required' => 'Ulasan wajib diisi.',
        ]);

        $booking = Booking::where('user_id', auth()->id())
            ->where('status', 'completed')
            ->findOrFail($bookingId);

        // Mencegah double review untuk booking yang sama
        if ($booking->review) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk pesanan ini.');
        }

        Review::create([
            'booking_id' => $booking->id,
            'user_id'    => auth()->id(),
            'villa_id'   => $booking->villa_id,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
        ]);

        return back()->with('success', 'Ulasan Anda berhasil dikirim! Terima kasih atas masukan Anda.');
    }
}