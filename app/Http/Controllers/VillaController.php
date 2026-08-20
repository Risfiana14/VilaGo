<?php

namespace App\Http\Controllers;

use App\Models\Villa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VillaController extends Controller
{
    // Fungsi ini yang tadi hilang/belum ada
    public function index()
    {
        $villas = Villa::latest()->get();
        return view('welcome', compact('villas'));
    }

    public function create()
    {
        return view('villas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'location' => 'required',
            'address' => 'required',
            'price_per_night' => 'required|numeric',
            'capacity' => 'required|numeric',
            'description' => 'required',
            'status' => 'required|in:available,booked,maintenance',
        ]);

        Villa::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'location' => $request->location,
            'address' => 'required',
            'price_per_night' => $request->price_per_night,
            'capacity' => $request->capacity,
            'description' => $request->description,
            'status' => $request->status,
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
            'title' => 'required',
            'location' => 'required',
            'address' => 'required',
            'price_per_night' => 'required|numeric',
            'capacity' => 'required|numeric',
            'description' => 'required',
            'status'=> 'required|in:available,booked,maintenance',
        ]);

        $villa->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'location' => $request->location,
            'address' => 'required',
            'price_per_night' => $request->price_per_night,
            'capacity' => $request->capacity,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('home')->with('success', 'Data vila berhasil diperbarui!');
    }

    public function destroy(Villa $villa)
    {
        $villa->delete();
        return redirect()->route('home')->with('success', 'Vila berhasil dihapus!');
    }
}