<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with('villa')->where('status', 'completed');

        // Filter berdasarkan rentang tanggal check-in
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('check_in', [$request->start_date, $request->end_date]);
        }

        $completedBookings = $query->latest()->get();

        // Perhitungan Ringkasan Statistik Keuangan
        $totalRevenue = $completedBookings->sum('total_price');
        $totalTransactions = $completedBookings->count();
        $averageRevenue = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;

        return view('reports.index', compact(
            'completedBookings',
            'totalRevenue',
            'totalTransactions',
            'averageRevenue'
        ));
    }
}