<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Menampilkan form login.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Menangani percobaan login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        // Validasi input email, password, dan role yang dipilih
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:admin,guru', // Memastikan role yang dipilih valid
        ]);

        // Mencari pengguna berdasarkan email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Jika pengguna belum ada, buat pengguna baru untuk simulasi
            $user = User::create([
                'name' => 'User ' . ucfirst($request->role), // Nama pengguna default
                'email' => $request->email,
                'password' => Hash::make($request->password), // Hash password
                'role' => $request->role, // Set role berdasarkan tombol login yang dipilih
            ]);
        } else {
            // Jika pengguna sudah ada, verifikasi password
            if (!Hash::check($request->password, $user->password)) {
                 throw ValidationException::withMessages([
                    'password' => [trans('auth.password')], // Pesan error password tidak cocok
                ]);
            }
            // Perbarui role pengguna jika berbeda (untuk simulasi fleksibilitas role)
            if ($user->role !== $request->role) {
                $user->update(['role' => $request->role]);
            }
        }

        // Login pengguna
        Auth::login($user);

        // Regenerasi session dan token untuk keamanan
        $request->session()->regenerate();

        // Redirect ke dashboard atau halaman yang dituju sebelumnya dengan pesan sukses
        return redirect()->intended('/dashboard')->with('success', 'Berhasil login sebagai ' . $request->role . '!');
    }

    /**
     * Menangani proses logout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Logout pengguna
        Auth::logout();

        // Invalidasi session dan regenerasi token untuk keamanan
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman utama (login) dengan pesan sukses
        return redirect('/')->with('success', 'Anda telah logout.');
    }
}
