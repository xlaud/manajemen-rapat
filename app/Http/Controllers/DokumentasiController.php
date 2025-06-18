<?php

namespace App\Http\Controllers;

use App\Models\Dokumentasi; // Impor model Dokumentasi
use App\Models\Agenda;     // Impor model Agenda untuk dropdown
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;     // Untuk mendapatkan user yang login
use Illuminate\Support\Facades\Storage; // Untuk mengelola file di storage

class DokumentasiController extends Controller
{
    /**
     * Menampilkan daftar semua dokumentasi (untuk Admin).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $dokumentasi = Dokumentasi::all(); // Mengambil semua data dokumentasi
        return view('dokumentasi.index', compact('dokumentasi'));
    }

    /**
     * Menampilkan form untuk menambahkan dokumentasi baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $agendas = Agenda::all(); // Mengambil semua agenda untuk dropdown
        return view('dokumentasi.create', compact('agendas'));
    }

    /**
     * Menyimpan dokumentasi baru ke database dan mengunggah file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input, termasuk validasi file
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png|max:5120', // Tipe dan ukuran file
            'agenda_id' => 'nullable|exists:agendas,id', // agenda_id opsional
        ]);

        $filePath = null; // Inisialisasi path file
        if ($request->hasFile('file')) {
            // Menyimpan file ke direktori 'storage/app/public/dokumentasi'
            // dan mendapatkan path relatifnya
            $filePath = $request->file('file')->store('public/dokumentasi');
        }

        // Membuat entri baru di tabel dokumentasi
        Dokumentasi::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath, // Simpan path file
            'agenda_id' => $request->agenda_id,
            'user_id' => Auth::id(), // ID user yang mengunggah
        ]);

        return redirect()->route('dokumentasi.index')->with('success', 'Dokumentasi berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit dokumentasi yang sudah ada.
     *
     * @param  \App\Models\Dokumentasi  $dokumentasi
     * @return \Illuminate\View\View
     */
    public function edit(Dokumentasi $dokumentasi)
    {
        $agendas = Agenda::all();
        return view('dokumentasi.edit', compact('dokumentasi', 'agendas'));
    }

    /**
     * Memperbarui dokumentasi yang sudah ada, termasuk mengganti file jika ada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dokumentasi  $dokumentasi
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Dokumentasi $dokumentasi)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png|max:5120',
            'agenda_id' => 'nullable|exists:agendas,id',
        ]);

        $filePath = $dokumentasi->file_path; // Ambil path file lama
        if ($request->hasFile('file')) {
            // Jika ada file baru diunggah, hapus file lama (jika ada)
            if ($filePath && Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
            // Simpan file baru
            $filePath = $request->file('file')->store('public/dokumentasi');
        }

        // Perbarui entri di database
        $dokumentasi->update([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath, // Update dengan path file baru atau tetap yang lama
            'agenda_id' => $request->agenda_id,
        ]);

        return redirect()->route('dokumentasi.index')->with('success', 'Dokumentasi berhasil diperbarui!');
    }

    /**
     * Menghapus dokumentasi dari database dan juga file terkait.
     *
     * @param  \App\Models\Dokumentasi  $dokumentasi
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Dokumentasi $dokumentasi)
    {
        // Hapus file dari storage jika ada
        if ($dokumentasi->file_path && Storage::exists($dokumentasi->file_path)) {
            Storage::delete($dokumentasi->file_path);
        }
        // Hapus entri dari database
        $dokumentasi->delete();
        return redirect()->route('dokumentasi.index')->with('success', 'Dokumentasi berhasil dihapus!');
    }

    /**
     * Mendownload file dokumentasi.
     *
     * @param  \App\Models\Dokumentasi  $dokumentasi
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|\Illuminate\Http\RedirectResponse
     */
    public function download(Dokumentasi $dokumentasi)
    {
        // Pastikan file_path ada dan file fisik ada di storage
        if ($dokumentasi->file_path && Storage::exists($dokumentasi->file_path)) {
            return Storage::download($dokumentasi->file_path);
        }
        return redirect()->back()->with('error', 'File tidak ditemukan atau sudah dihapus.');
    }
}
