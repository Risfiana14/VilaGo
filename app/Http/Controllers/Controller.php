<?php

namespace App\Http\Controllers;
use App\Models\Villa;
use Illuminate\Http\Request;

abstract class Controller
{
    //
}

class VillaController extends Controller
{
    public function index()
    {
        $villas = Villa::latest()->get();
        return view('welcome', compact('villas'));
    }
}