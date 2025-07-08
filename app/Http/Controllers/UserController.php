<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'guru')->oldest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.form');
    }

    /**
     * Menyimpan guru baru.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nip' => 'nullable|string|unique:users,nip', // NIP nanti
        ]);

        // Password default
        $validatedData['password'] = Hash::make('rapatguru');
        $validatedData['role'] = 'guru';

        User::create($validatedData);

        return redirect()->route('users.index')->with('success', 'Guru baru berhasil ditambahkan dengan password default.');
    }

    public function edit(User $user)
    {
        return view('admin.users.form', compact('user'));
    }

    /**
     * Memperbarui data guru.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'nip' => ['nullable', 'string', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8', // Password opsional saat update
        ]);

        // Hanya update password jika diisi.
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }
        
        $user->update($validatedData);

        return redirect()->route('users.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
