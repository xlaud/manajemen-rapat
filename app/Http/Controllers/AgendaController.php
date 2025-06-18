<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    /**
     * Menampilkan daftar semua agenda rapat.
     * Admin melihat semua agenda.
     * Guru (jika diarahkan ke sini) hanya melihat agenda yang dibuatnya.
     */
    public function index()
    {
        $agendas = Agenda::with('user')
            ->when(Auth::user()->role === 'guru', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->get();
        
        return view('agendas.index', compact('agendas'));
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

        Agenda::create([
            'title' => $request->title,
            'description' => $request->description,
            'meeting_date' => $request->meeting_date,
            'meeting_time' => $request->meeting_time,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('agendas.index')->with('success', 'Agenda berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit agenda.
     */
    public function edit(Agenda $agenda)
    {
        // Otorisasi: Hanya admin atau pemilik agenda yang boleh mengedit.
        if (auth()->user()->role !== 'admin' && auth()->id() !== $agenda->user_id) {
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
        // Otorisasi: Hanya admin atau pemilik agenda yang boleh memperbarui.
        if (auth()->user()->role !== 'admin' && auth()->id() !== $agenda->user_id) {
            abort(403, 'ANDA TIDAK DIIZINKAN MELAKUKAN AKSI INI.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'meeting_date' => 'required|date',
            'meeting_time' => 'required|date_format:H:i',
        ]);

        $agenda->update([
            'title' => $request->title,
            'description' => $request->description,
            'meeting_date' => $request->meeting_date,
            'meeting_time' => $request->meeting_time,
        ]);

        return redirect()->route('agendas.index')->with('success', 'Agenda berhasil diperbarui!');
    }

    /**
     * Menghapus agenda dari database.
     */
    public function destroy(Agenda $agenda)
    {
        // Otorisasi: Hanya admin atau pemilik agenda yang boleh menghapus.
        if (auth()->user()->role !== 'admin' && auth()->id() !== $agenda->user_id) {
            abort(403, 'ANDA TIDAK DIIZINKAN MELAKUKAN AKSI INI.');
        }
        
        $agenda->delete();

        return redirect()->route('agendas.index')->with('success', 'Agenda berhasil dihapus.');
    }

    /**
     * Menampilkan daftar agenda untuk guru.
     */
    public function guruIndex()
    {
        // Method ini sepertinya belum digunakan di rute, namun saya biarkan
        // jika Anda memerlukannya nanti. Asumsinya adalah guru melihat semua agenda.
        $agendas = Agenda::latest()->get();
        return view('agendas.guru_index', compact('agendas'));
    }
}