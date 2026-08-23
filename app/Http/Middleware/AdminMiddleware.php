<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Jika belum login, lempar ke halaman login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Jika user adalah admin, lanjutkan akses
        if (Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Jika user biasa mencoba akses rute admin, kembalikan ke portal user
        return redirect()->route('user.dashboard')->with('error', 'Akses khusus Admin!');
    }
}