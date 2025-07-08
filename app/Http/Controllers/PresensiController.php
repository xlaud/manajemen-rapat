<?php

namespace App\Http\Controllers;

use App\Models\Presensi; 
use App\Models\Agenda;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class PresensiController extends Controller
{
    /**
     * Menampilkan rekap presensi yang dikelompokkan per agenda (untuk Admin).
     */
    public function index()
    {
        $agendas = Agenda::with('presensi.user')->latest()->get();
        
        // Mengirim variabel $agendas (bukan $presensi) ke view.
        return view('presensi.index', compact('agendas'));
    }

    /**
     * Menampilkan form presensi untuk agenda tertentu.
     */
    public function createForGuru(Agenda $agenda)
    {
        // Cek apakah guru sudah pernah mengisi presensi untuk agenda ini
        $existingPresensi = $agenda->presensi()->where('user_id', Auth::id())->first();

        return view('presensi.create', [
            'agenda' => $agenda,
            'existingPresensi' => $existingPresensi
        ]);
    }

    /**
     * Menyimpan data presensi untuk agenda tertentu.
     */
    public function storeForGuru(Request $request, Agenda $agenda)
    {
        $request->validate([
            'status' => 'required|in:hadir,tidak_hadir,izin',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Cek lagi untuk mencegah pengisian ganda
        $alreadyExists = $agenda->presensi()->where('user_id', Auth::id())->exists();
        if ($alreadyExists) {
            return redirect()->route('agendas.guru')->with('error', 'Anda sudah mengisi presensi untuk agenda ini.');
        }

        // Simpan data presensi ke database, terhubung dengan agenda yang benar
        $agenda->presensi()->create([
            'user_id' => Auth::id(),
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('agendas.guru')->with('success', 'Presensi berhasil dicatat. Terima kasih.');
    }
}
