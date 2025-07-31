<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman form untuk mengubah password.
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Memproses permintaan perubahan password.
     */
    public function updatePassword(Request $request)
    {
        //Validasi input
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        //Cek apakah password saat ini cocok
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Password yang Anda masukkan tidak cocok dengan password saat ini.',
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        //Redirect kembali dengan pesan sukses
        return redirect()->route('profile.edit')->with('success', 'Password Anda berhasil diperbarui!');
    }
}