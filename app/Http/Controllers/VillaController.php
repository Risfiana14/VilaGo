<?php

namespace App\Http\Controllers;

use App\Models\Villa;
use App\Models\Booking; // Import Model Booking
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VillaController extends Controller
{
    public function index(Request $request)
    {
        $query = Villa::query();

        // Filter berdasarkan kata kunci nama / lokasi
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan status vila
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $villas = $query->latest()->get();

        // Hitung statistik
        $totalVillas = Villa::count();
        $availableVillas = Villa::where('status', 'available')->count();
        $activeBookings = Booking::whereIn('status', ['pending', 'confirmed'])->count();
        $totalRevenue = Booking::where('status', 'completed')->sum('total_price');

        return view('welcome', compact('villas', 'totalVillas', 'availableVillas', 'activeBookings', 'totalRevenue'));
    }

    public function create()
    {
        return view('villas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'           => 'required',
            'location'        => 'required',
            'address'         => 'required',
            'price_per_night' => 'required|numeric',
            'capacity'        => 'required|numeric',
            'description'     => 'required',
            'status'          => 'required|in:available,booked,maintenance',
        ]);

        Villa::create([
            'title'           => $request->title,
            'slug'            => Str::slug($request->title),
            'location'        => $request->location,
            'address'         => $request->address,
            'price_per_night' => $request->price_per_night,
            'capacity'        => $request->capacity,
            'description'     => $request->description,
            'status'          => $request->status,
        ]);

        return redirect()->route('home')->with('success', 'Vila berhasil ditambahkan!');
    }

    public function edit(Villa $villa)
    {
        return view('villas.edit', compact('villa'));
    }

    public function update(Request $request, Villa $villa)
    {
        $request->validate([
            'title'           => 'required',
            'location'        => 'required',
            'address'         => 'required',
            'price_per_night' => 'required|numeric',
            'capacity'        => 'required|numeric',
            'description'     => 'required',
            'status'          => 'required|in:available,booked,maintenance',
        ]);

        $villa->update([
            'title'           => $request->title,
            'slug'            => Str::slug($request->title),
            'location'        => $request->location,
            'address'         => $request->address,
            'price_per_night' => $request->price_per_night,
            'capacity'        => $request->capacity,
            'description'     => $request->description,
            'status'          => $request->status,
        ]);

        return redirect()->route('home')->with('success', 'Data vila berhasil diperbarui!');
    }

    public function destroy(Villa $villa)
    {
        $villa->delete();
        return redirect()->route('home')->with('success', 'Vila berhasil dihapus!');
    }
}