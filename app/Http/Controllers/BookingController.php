<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Villa;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with('villa');

        // Filter berdasarkan pencarian nama tamu atau nomor HP
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('customer_name', 'like', '%' . $request->search . '%')
                ->orWhere('customer_phone', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan status reservasi
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->latest()->get();

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

        $booking = Booking::create([
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

    // Method edit() yang tadi hilang
    public function edit(Booking $booking)
    {
        $villas = Villa::all();
        return view('bookings.edit', compact('booking', 'villas'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'villa_id'       => 'required|exists:villas,id',
            'customer_name'  => 'required|string',
            'customer_phone' => 'required|string',
            'check_in'       => 'required|date',
            'check_out'      => 'required|date|after:check_in',
            'total_price'    => 'required|numeric',
            'status'         => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $booking->update($request->all());

        return redirect()->route('bookings.index')->with('success', 'Data reservasi berhasil diperbarui!');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index')->with('success', 'Data reservasi berhasil dihapus!');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled'
        ]);

        $booking->update(['status' => $request->status]);

        // Otomatisasi Sinkronisasi Status Vila
        if ($request->status === 'confirmed') {
            $booking->villa()->update(['status' => 'booked']);
        } elseif (in_array($request->status, ['completed', 'cancelled'])) {
            $booking->villa()->update(['status' => 'available']);
        }

        return redirect()->back()->with('success', 'Status reservasi & ketersediaan vila berhasil diperbarui!');
    }
}