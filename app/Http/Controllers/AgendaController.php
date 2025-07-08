<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    /**
     * Menampilkan daftar semua agenda rapat untuk Admin.
     */
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES KE HALAMAN INI.');
        }

        $agendas = Agenda::with('user')->latest()->get();
        return view('agendas.index', compact('agendas'));
    }

    /**
     * Menampilkan daftar agenda untuk Guru.
     */
    public function guruIndex()
    {
        $agendas = Agenda::with('presensi')->latest()->get();
        return view('agendas.guru_index', compact('agendas'));
    }
    
    /**
     * Menampilkan detail agenda beserta daftar hadirnya (untuk Admin).
     */
    public function show(Agenda $agenda)
    {
        $agenda->load('presensi.user');
        
        return view('admin.agendas.show', compact('agenda'));
    }

    /**
     * Menampilkan form untuk membuat agenda baru.
     */
    public function create()
    {
        return view('agendas.create', [
            'agenda' => new Agenda()
        ]);
    }

    /**
     * Menyimpan agenda baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'meeting_date' => 'required|date',
            'meeting_time' => 'required|date_format:H:i',
        ]);

        Agenda::create(array_merge($request->all(), ['user_id' => Auth::id()]));

        return redirect()->route('agendas.index')->with('success', 'Agenda berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit agenda.
     */
    public function edit(Agenda $agenda)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'ANDA TIDAK DIIZINKAN MENGAKSES HALAMAN INI.');
        }

        return view('agendas.edit', [
            'agenda' => $agenda
        ]);
    }

    /**
     * Memperbarui data agenda di database.
     */
    public function update(Request $request, Agenda $agenda)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'ANDA TIDAK DIIZINKAN MELAKUKAN AKSI INI.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'meeting_date' => 'required|date',
            'meeting_time' => 'required|date_format:H:i',
        ]);

        $agenda->update($request->all());

        return redirect()->route('agendas.index')->with('success', 'Agenda berhasil diperbarui!');
    }

    /**
     * Menghapus agenda dari database.
     */
    public function destroy(Agenda $agenda)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'ANDA TIDAK DIIZINKAN MELAKUKAN AKSI INI.');
        }
        
        $agenda->delete();

        return redirect()->route('agendas.index')->with('success', 'Agenda berhasil dihapus.');
    }
}
