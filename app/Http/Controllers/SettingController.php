<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Ambil data pengaturan pertama, jika belum ada buat data default
        $setting = Setting::firstOrCreate([], [
            'app_name'    => 'VilaGo',
            'app_email'   => 'admin@vilago.com',
            'app_phone'   => '081234567890',
            'app_address' => 'Jl. Raya Utama No. 1, Batu, Malang',
            'service_fee' => 0,
        ]);

        return view('settings.index', compact('setting'));
    }

    public function update(Request $request, Setting $setting)
    {
        $request->validate([
            'app_name'    => 'required|string|max:255',
            'app_email'   => 'required|email|max:255',
            'app_phone'   => 'required|string|max:20',
            'app_address' => 'required|string',
            'service_fee' => 'required|numeric|min:0|max:100',
        ]);

        $setting->update($request->all());

        return redirect()->back()->with('success', 'Pengaturan sistem berhasil diperbarui!');
    }
}