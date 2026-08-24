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
            'customer_name'  => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'check_in'       => 'required|date',
            'check_out'      => 'required|date|after:check_in',
        ]);

        $villa = \App\Models\Villa::findOrFail($request->villa_id);

        // Hitung durasi dan total harga
        $checkIn = \Carbon\Carbon::parse($request->check_in);
        $checkOut = \Carbon\Carbon::parse($request->check_out);
        $nights = $checkIn->diffInDays($checkOut);
        $totalPrice = $nights * $villa->price_per_night;

        \App\Models\Booking::create([
            'villa_id'       => $villa->id,
            'customer_name'  => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'check_in'       => $request->check_in,
            'check_out'      => $request->check_out,
            'total_price'    => $totalPrice,
            'status'         => 'pending',
        ]);

        // Redireksi berdasarkan Role
    if (auth()->user()->role === 'admin') {
        return redirect()->route('bookings.index')->with('success', 'Reservasi berhasil ditambahkan!');
    }

    return redirect()->route('user.my_bookings')->with('success', 'Pemesanan berhasil! Silakan lakukan pembayaran dan unggah bukti transfer.');
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

    // Halaman Riwayat Pemesanan Saya (User)
    public function myBookings()
    {
        $bookings = \App\Models\Booking::with('villa')
            ->where('customer_name', auth()->user()->name)
            ->latest()
            ->get();

        return view('user.my_bookings', compact('bookings'));
    }

    // Proses Upload Bukti Pembayaran
    public function uploadPayment(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'payment_proof'  => 'required|image|mimes:jpeg,jpg,png,webp|max:5120', // Maksimal 5MB
        ], [
            'payment_proof.required' => 'File bukti pembayaran wajib diunggah.',
            'payment_proof.image'    => 'File harus berupa gambar.',
            'payment_proof.mimes'    => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'payment_proof.max'      => 'Ukuran file gambar maksimal 5MB.',
        ]);

        $booking = \App\Models\Booking::findOrFail($id);

        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Pastikan direktori folder tersedia
            $destinationPath = public_path('assets/images/payments');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Pindahkan file ke folder public/assets/images/payments
            $file->move($destinationPath, $fileName);
            
            // Update data booking
            $booking->update([
                'payment_proof'  => $fileName,
                'payment_method' => $request->payment_method,
            ]);
        }

        return redirect()->route('user.my_bookings')->with('success', 'Bukti pembayaran berhasil diunggah! Admin akan segera memverifikasi pesanan Anda.');
    }
}