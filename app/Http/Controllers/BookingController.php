<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Villa;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('villa')->latest()->get();
        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $villas = Villa::where('status', 'available')->get();
        return view('bookings.create', compact('villas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'villa_id'       => 'required|exists:villas,id',
            'customer_name'  => 'required|string',
            'customer_phone' => 'required|string',
            'check_in'       => 'required|date',
            'check_out'      => 'required|date|after:check_in',
            'total_price'    => 'required|numeric',
        ]);

        Booking::create([
            'villa_id'       => $request->villa_id,
            'customer_name'  => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'check_in'       => $request->check_in,
            'check_out'      => $request->check_out,
            'total_price'    => $request->total_price,
            'status'         => 'pending',
        ]);

        return redirect()->route('bookings.index')->with('success', 'Reservasi berhasil dibuat!');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled'
        ]);

        $booking->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status reservasi berhasil diperbarui!');
    }
}