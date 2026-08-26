<?php

namespace App\Http\Controllers;

use App\Models\Villa;
use App\Models\Booking;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VillaController extends Controller
{
    public function index(Request $request)
    {
        $query = Villa::with('facilities');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $villas = $query->latest()->get();

        $totalVillas = Villa::count();
        $availableVillas = Villa::where('status', 'available')->count();
        $activeBookings = Booking::whereIn('status', ['pending', 'confirmed'])->count();
        $totalRevenue = Booking::where('status', 'completed')->sum('total_price');

        return view('welcome', compact('villas', 'totalVillas', 'availableVillas', 'activeBookings', 'totalRevenue'));
    }

    public function create()
    {
        $facilities = Facility::all();
        return view('villas.create', compact('facilities'));
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
            'facilities'      => 'nullable|array',
        ]);

        $villa = Villa::create([
            'title'           => $request->title,
            'slug'            => Str::slug($request->title),
            'location'        => $request->location,
            'address'         => $request->address,
            'price_per_night' => $request->price_per_night,
            'capacity'        => $request->capacity,
            'description'     => $request->description,
            'status'          => $request->status,
        ]);

        if ($request->has('facilities')) {
            $villa->facilities()->attach($request->facilities);
        }

        return redirect()->route('home')->with('success', 'Vila berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail vila untuk pelanggan/user
     */
    public function show($id)
    {
        $villa = Villa::with('facilities')->findOrFail($id);

        // Memeriksa jika ada file view 'villas.show', jika tidak ada gunakan 'user.villa_detail'
        if (view()->exists('villas.show')) {
            return view('villas.show', compact('villa'));
        }

        return view('user.villa_detail', compact('villa'));
    }

    public function edit(Villa $villa)
    {
        $facilities = Facility::all();
        return view('villas.edit', compact('villa', 'facilities'));
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
            'facilities'      => 'nullable|array',
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

        $villa->facilities()->sync($request->facilities ?? []);

        return redirect()->route('home')->with('success', 'Data vila berhasil diperbarui!');
    }

    public function destroy(Villa $villa)
    {
        $villa->delete();
        return redirect()->route('home')->with('success', 'Vila berhasil dihapus!');
    }
}