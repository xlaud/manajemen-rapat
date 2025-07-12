<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Menangani permintaan masuk.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string ...$roles  // PERUBAHAN: Menggunakan spread operator untuk menerima beberapa peran
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Memeriksa apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Anda harus login untuk mengakses halaman ini.');
        }

        // Mengambil peran pengguna yang sedang login
        $userRole = Auth::user()->role;

        // Memeriksa apakah peran pengguna ada di dalam daftar peran yang diizinkan
        if (!in_array($userRole, $roles)) {
            // Jika peran tidak ada dalam daftar, redirect dengan pesan error
            return redirect('/dashboard')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        // Jika peran sesuai, lanjutkan permintaan
        return $next($request);
    }
}
