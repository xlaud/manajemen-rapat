<?php

namespace App\Http\Controllers;

use App\Models\Notula; // Impor model Notula
use App\Models\Agenda; // Impor model Agenda (untuk dropdown pilihan agenda)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user yang login
// Hapus import untuk Http dan Log yang digunakan untuk Gemini API

class NotulaController extends Controller
{
    /**
     * Menampilkan daftar semua notula rapat.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $notulas = Notula::all(); // Mengambil semua notula
        return view('notulas.index', compact('notulas'));
    }

    /**
     * Menampilkan form untuk membuat notula baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Mengambil semua agenda untuk ditampilkan di dropdown pilihan
        $agendas = \App\Models\Agenda::all();
    
        // Membuat instance Notula baru yang kosong untuk di-passing ke form
        $notula = new \App\Models\Notula();

        // Mengirim variabel agendas dan notula ke view
        return view('notulas.create', compact('agendas', 'notula'));
    }

    /**
     * Menyimpan notula baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'agenda_id' => 'required|exists:agendas,id', // Memastikan agenda_id valid
        ]);

        // Membuat entri notula baru
        Notula::create([
            'title' => $request->title,
            'description' => $request->description,
            'agenda_id' => $request->agenda_id,
            'user_id' => Auth::id(), // Menyimpan ID user yang menulis notula
        ]);

        return redirect()->route('notulas.index')->with('success', 'Notula berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit notula tertentu.
     *
     * @param  \App\Models\Notula  $notula
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Notula $notula)
    {
        $agendas = Agenda::all(); // Mengambil semua agenda untuk dropdown pilihan
        // Pastikan hanya admin atau user yang membuat notula yang bisa mengedit
        if (Auth::user()->role !== 'admin' && Auth::id() !== $notula->user_id) {
            return redirect()->route('notulas.index')->with('error', 'Anda tidak memiliki izin untuk mengedit notula ini.');
        }
        return view('notulas.edit', compact('notula', 'agendas'));
    }

    /**
     * Memperbarui data notula di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notula  $notula
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Notula $notula)
    {
        // Pastikan hanya admin atau user yang membuat notula yang bisa mengupdate
        if (Auth::user()->role !== 'admin' && Auth::id() !== $notula->user_id) {
            return redirect()->route('notulas.index')->with('error', 'Anda tidak memiliki izin untuk memperbarui notula ini.');
        }

        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'agenda_id' => 'required|exists:agendas,id',
        ]);

        // Memperbarui entri notula
        $notula->update($request->all());

        return redirect()->route('notulas.index')->with('success', 'Notula berhasil diperbarui!');
    }

    /**
     * Menghapus notula dari database.
     *
     * @param  \App\Models\Notula  $notula
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Notula $notula)
    {
        // Pastikan hanya admin atau user yang membuat notula yang bisa menghapus
        if (Auth::user()->role !== 'admin' && Auth::id() !== $notula->user_id) {
            return redirect()->route('notulas.index')->with('error', 'Anda tidak memiliki izin untuk menghapus notula ini.');
        }
        $notula->delete();
        return redirect()->route('notulas.index')->with('success', 'Notula berhasil dihapus!');
    }

    /**
     * Menampilkan daftar notula rapat untuk guru (hanya lihat).
     *
     * @return \Illuminate\View\View
     */
    public function guruIndex()
    {
        $notulas = Notula::all(); // Guru melihat semua notula
        return view('notulas.guru_index', compact('notulas'));
    }
}
