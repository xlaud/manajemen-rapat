<?php

namespace App\Http\Controllers;

use App\Models\Presensi; // Impor model Presensi
use App\Models\Agenda;   // Impor model Agenda untuk dropdown
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user yang login

class PresensiController extends Controller
{
    /**
     * Menampilkan daftar presensi (untuk Admin).
     * Admin dapat melihat semua catatan presensi dari guru.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil semua data presensi dan meng-eager load relasi user dan agenda
        $presensi = Presensi::with(['user', 'agenda'])->get();
        return view('presensi.index', compact('presensi'));
    }

    /**
     * Menampilkan form untuk guru mengisi presensi.
     * Guru akan memilih agenda rapat yang akan dihadiri.
     *
     * @return \Illuminate\View\View
     */
    public function createForGuru()
    {
        // Mengambil semua agenda rapat yang tersedia agar guru bisa memilihnya
        $agendas = Agenda::all();
        return view('presensi.create', compact('agendas'));
    }

    /**
     * Menyimpan data presensi yang diisi oleh guru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeForGuru(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'agenda_id' => 'required|exists:agendas,id', // Memastikan agenda_id ada di tabel agendas
            'status' => 'required|in:Hadir,Izin,Sakit,Alpha', // Status harus salah satu dari opsi ini
            'notes' => 'nullable|string|max:255', // Catatan opsional, maksimal 255 karakter
        ]);

        // Cek apakah guru sudah presensi untuk agenda ini sebelumnya
        $existingPresensi = Presensi::where('user_id', Auth::id())
                                    ->where('agenda_id', $request->agenda_id)
                                    ->first();

        if ($existingPresensi) {
            // Jika sudah ada, kembalikan ke halaman sebelumnya dengan pesan error
            return redirect()->back()->with('error', 'Anda sudah mengisi presensi untuk agenda ini.');
        }

        // Jika belum ada, buat catatan presensi baru
        Presensi::create([
            'user_id' => Auth::id(), // ID user yang sedang login (guru)
            'agenda_id' => $request->agenda_id,
            'status' => $request->status,
            'notes' => $request->notes,
            'presensi_time' => now(), // Waktu presensi saat ini (Carbon instance)
        ]);

        // Redirect kembali ke form presensi dengan pesan sukses
        return redirect()->route('presensi.create')->with('success', 'Presensi berhasil disimpan!');
    }

    // Anda dapat menambahkan metode CRUD lainnya untuk admin di sini
    // Misalnya, admin ingin mengedit atau menghapus catatan presensi
    /*
    public function edit(Presensi $presensi)
    {
        $agendas = Agenda::all();
        $users = User::where('role', 'guru')->get(); // Hanya guru yang bisa presensi
        return view('presensi.edit', compact('presensi', 'agendas', 'users'));
    }

    public function update(Request $request, Presensi $presensi)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'agenda_id' => 'required|exists:agendas,id',
            'status' => 'required|in:Hadir,Izin,Sakit,Alpha',
            'notes' => 'nullable|string|max:255',
            'presensi_time' => 'required|date', // Atau 'datetime' jika ada waktu
        ]);

        $presensi->update($request->all());
        return redirect()->route('presensi.index')->with('success', 'Presensi berhasil diperbarui!');
    }

    public function destroy(Presensi $presensi)
    {
        $presensi->delete();
        return redirect()->route('presensi.index')->with('success', 'Presensi berhasil dihapus!');
    }
    */
}
