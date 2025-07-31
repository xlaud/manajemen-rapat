<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresensiController extends Controller
{
    /**
     * Menampilkan halaman rekapitulasi presensi untuk Admin dengan pencarian dan pagination.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $agendas = Agenda::query()
            ->with('presensi.user')
            ->when($search, function ($query, $search) {
                // Cari berdasarkan judul agenda
                return $query->where('title', 'like', "%{$search}%");
            })
            ->latest('meeting_date')
            ->paginate(10);

        return view('presensi.index', compact('agendas'));
    }

    /**
     * Menampilkan form untuk GURU mengisi presensinya sendiri.
     */
    public function createForGuru(Agenda $agenda)
    {
        // Cek apakah guru yang sedang login sudah pernah mengisi presensi
        $existingPresensi = Presensi::where('agenda_id', $agenda->id)
                                      ->where('user_id', Auth::id())
                                      ->first();

        return view('presensi.create', compact('agenda', 'existingPresensi'));
    }

    /**
     * Menyimpan data presensi yang diisi oleh GURU.
     */
    public function storeForGuru(Request $request, Agenda $agenda)
    {
        $request->validate([
            'status' => 'required|in:hadir,tidak_hadir,izin',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // mengecek untuk mencegah pengisian ganda
        $alreadyExists = Presensi::where('agenda_id', $agenda->id)
                                   ->where('user_id', Auth::id())
                                   ->exists();

        if ($alreadyExists) {
            return redirect()->route('agendas.guru')->with('error', 'Anda sudah mengisi presensi untuk agenda ini.');
        }

        // Simpan data presensi
        Presensi::create([
            'agenda_id' => $agenda->id,
            'user_id' => Auth::id(),
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('agendas.guru')->with('success', 'Presensi berhasil dicatat.');
    }
}