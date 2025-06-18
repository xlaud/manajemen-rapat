<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mengakses data pengguna yang login

class CheckUserRole
{
    /**
     * Menangani permintaan masuk.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $role  // Parameter role yang akan dilewatkan dari rute (misal: 'admin', 'guru')
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // 1. Periksa apakah pengguna sudah login
        if (!Auth::check()) {
            // Jika belum login, redirect ke halaman login dengan pesan error
            return redirect('/')->with('error', 'Anda harus login untuk mengakses halaman ini.');
        }

        // 2. Periksa apakah role pengguna yang login sesuai dengan role yang dibutuhkan
        //    Auth::user()->role akan mengambil nilai dari kolom 'role' di tabel users
        if (Auth::user()->role !== $role) {
            // Jika role tidak sesuai, redirect ke dashboard (atau halaman lain) dengan pesan error
            return redirect('/dashboard')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        // Jika semua pemeriksaan berhasil, lanjutkan permintaan ke controller
        return $next($request);
    }
}
