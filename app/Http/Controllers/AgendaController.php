<?php

namespace App\Http\Controllers;

use App\Models\Agenda; // Impor model Agenda
use App\Models\User;   // Impor model User (jika ingin mengakses relasi user)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user yang login
// Hapus import untuk Http dan Log yang digunakan untuk Gemini API

class AgendaController extends Controller
{
    /**
     * Menampilkan daftar semua agenda rapat (untuk Admin).
     * Jika user adalah guru, hanya tampilkan agenda yang dibuatnya.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Admin melihat semua agenda, Guru hanya melihat agenda yang dibuatnya sendiri
        $agendas = Agenda::when(Auth::user()->role === 'guru', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();
        return view('agendas.index', compact('agendas'));
    }

    /**
     * Menampilkan form untuk membuat agenda baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('agendas.create');
    }

    /**
     * Menyimpan agenda baru ke database.
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
            // Tambahkan validasi untuk meeting_date, meeting_time jika ada di form
        ]);

        // Membuat entri agenda baru
        Agenda::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(), // Menyimpan ID user yang membuat agenda
            // Pastikan Anda menambahkan meeting_date dan meeting_time di sini jika ada di form
        ]);

        return redirect()->route('agendas.index')->with('success', 'Agenda berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit agenda tertentu.
     *
     * @param  \App\Models\Agenda  $agenda
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Agenda $agenda)
    {
        // Pastikan hanya admin atau user yang membuat agenda yang bisa mengedit
        if (Auth::user()->role !== 'admin' && Auth::id() !== $agenda->user_id) {
            return redirect()->route('agendas.index')->with('error', 'Anda tidak memiliki izin untuk mengedit agenda ini.');
        }
        return view('agendas.edit', compact('agenda'));
    }

    /**
     * Memperbarui data agenda di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agenda  $agenda
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Agenda $agenda)
    {
        // Pastikan hanya admin atau user yang membuat agenda yang bisa mengupdate
        if (Auth::user()->role !== 'admin' && Auth::id() !== $agenda->user_id) {
            return redirect()->route('agendas.index')->with('error', 'Anda tidak memiliki izin untuk memperbarui agenda ini.');
        }

        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            // Tambahkan validasi untuk meeting_date, meeting_time jika ada
        ]);

        // Memperbarui entri agenda
        $agenda->update([
            'title' => $request->title,
            'description' => $request->description,
            // Pastikan Anda menambahkan meeting_date dan meeting_time di sini jika ada di form
        ]);

        return redirect()->route('agendas.index')->with('success', 'Agenda berhasil diperbarui!');
    }

    /**
     * Menghapus agenda dari database.
     *
     * @param  \App\Models\Agenda  $agenda
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Agenda $agenda)
    {
        // Pastikan hanya admin atau user yang membuat agenda yang bisa menghapus
        if (Auth::user()->role !== 'admin' && Auth::id() !== $agenda->user_id) {
            return redirect()->route('agendas.index')->with('error', 'Anda tidak memiliki izin untuk menghapus agenda ini.');
        }
        $agenda->delete();
        return redirect()->route('agendas.index')->with('success', 'Agenda berhasil dihapus!');
    }

    /**
     * Menampilkan daftar agenda rapat untuk guru (hanya lihat).
     * Guru dapat melihat semua agenda rapat.
     *
     * @return \Illuminate\View\View
     */
    public function guruIndex()
    {
        $agendas = Agenda::all(); // Guru melihat semua agenda
        return view('agendas.guru_index', compact('agendas'));
    }
}
