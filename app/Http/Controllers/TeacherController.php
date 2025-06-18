<?php

namespace App\Http\Controllers;

use App\Models\Teacher; // Impor model Teacher
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Menampilkan daftar semua guru.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $teachers = Teacher::all(); // Mengambil semua data guru dari database
        return view('teachers.index', compact('teachers')); // Melewatkan data ke view
    }

    /**
     * Menampilkan form untuk membuat guru baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Melewatkan 'mode' untuk digunakan di komponen form
        return view('teachers.create');
    }

    /**
     * Menyimpan guru baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:teachers', // Email harus unik
            'nip' => 'required|string|max:255|unique:teachers', // NIP harus unik
        ]);

        // Membuat entri guru baru di database
        Teacher::create($request->all());

        // Redirect ke halaman daftar guru dengan pesan sukses
        return redirect()->route('teachers.index')->with('success', 'Guru berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit guru tertentu.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\View\View
     */
    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher')); // Melewatkan objek guru ke view
    }

    /**
     * Memperbarui data guru di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Teacher $teacher)
    {
        // Validasi input, dengan pengecualian unik untuk guru yang sedang diedit
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:teachers,email,' . $teacher->id,
            'nip' => 'required|string|max:255|unique:teachers,nip,' . $teacher->id,
        ]);

        // Memperbarui entri guru di database
        $teacher->update($request->all());

        // Redirect ke halaman daftar guru dengan pesan sukses
        return redirect()->route('teachers.index')->with('success', 'Data guru berhasil diperbarui!');
    }

    /**
     * Menghapus guru dari database.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Teacher $teacher)
    {
        // Menghapus entri guru dari database
        $teacher->delete();
        // Redirect ke halaman daftar guru dengan pesan sukses
        return redirect()->route('teachers.index')->with('success', 'Guru berhasil dihapus!');
    }
}
