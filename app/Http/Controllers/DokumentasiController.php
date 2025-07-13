<?php

namespace App\Http\Controllers;

use App\Models\Dokumentasi;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumentasiController extends Controller
{
    /**
     * Menampilkan daftar semua dokumentasi dengan fitur pencarian dan pagination.
     */
    public function index(Request $request)
    {
        // Ambil kata kunci pencarian dari URL
        $search = $request->query('search');

        // Query dasar untuk dokumentasi
        $dokumentasis = Dokumentasi::query()
            ->with('agenda') // Eager load relasi agenda untuk efisiensi
            ->when($search, function ($query, $search) {
                // Cari berdasarkan caption atau judul agenda terkait
                return $query->where('caption', 'like', "%{$search}%")
                             ->orWhereHas('agenda', function ($q) use ($search) {
                                 $q->where('title', 'like', "%{$search}%");
                             });
            })
            ->latest()
            ->paginate(9); // Paginate 9, cocok untuk layout galeri

        return view('dokumentasi.index', compact('dokumentasis'));
    }

    /**
     * Menampilkan form untuk menambahkan dokumentasi baru.
     */
    public function create()
    {
        $agendas = Agenda::latest()->get();
        return view('dokumentasi.create', compact('agendas'));
    }

    /**
     * Menyimpan dokumentasi baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'agenda_id' => 'required|exists:agendas,id',
            'images' => 'required|array', // Validasi bahwa 'images' adalah array
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi setiap file dalam array
            'caption' => 'nullable|string|max:255',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Simpan setiap gambar dan kumpulkan path-nya
                $path = $image->store('dokumentasi', 'public');
                $imagePaths[] = $path;
            }
        }

        Dokumentasi::create([
            'agenda_id' => $request->agenda_id,
            // Simpan array path gambar sebagai string JSON
            'image_path' => json_encode($imagePaths), 
            'caption' => $request->caption,
        ]);

        return redirect()->route('dokumentasi.index')->with('success', 'Dokumentasi berhasil ditambahkan.');
    }

    /**
     * Menghapus dokumentasi dari database.
     */
    public function destroy(Dokumentasi $dokumentasi)
    {
        // Decode string JSON menjadi array path gambar
        $imagePaths = json_decode($dokumentasi->image_path, true);

        // Pastikan hasil decode adalah array sebelum di-loop
        if (is_array($imagePaths)) {
            foreach ($imagePaths as $path) {
                if ($path && Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        }
        
        $dokumentasi->delete();
        
        return redirect()->route('dokumentasi.index')->with('success', 'Dokumentasi berhasil dihapus.');
    }
}