<?php

namespace App\Http\Controllers;

use App\Models\Dokumentasi;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class DokumentasiController extends Controller
{
    /**
     * Menampilkan daftar semua dokumentasi dengan fitur pencarian dan pagination.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $dokumentasis = Dokumentasi::query()
            ->with('agenda')
            ->when($search, function ($query, $search) {
                return $query->where('caption', 'like', "%{$search}%")
                             ->orWhereHas('agenda', function ($q) use ($search) {
                                 $q->where('title', 'like', "%{$search}%");
                             });
            })
            ->latest()
            ->paginate(9);

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
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'caption' => 'nullable|string|max:255',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('dokumentasi', 'public');
                $imagePaths[] = $path;
            }
        }

        Dokumentasi::create([
            'agenda_id' => $request->agenda_id,
            'image_path' => json_encode($imagePaths), 
            'caption' => $request->caption,
        ]);

        return redirect()->route('dokumentasi.index')->with('success', 'Dokumentasi berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail dokumentasi.
     */
    public function show(Dokumentasi $dokumentasi)
    {
        return view('dokumentasi.show', compact('dokumentasi'));
    }

    /**
     * Menampilkan form untuk mengedit dokumentasi.
     */
    public function edit(Dokumentasi $dokumentasi)
    {
        $agendas = Agenda::latest()->get();
        return view('dokumentasi.edit', compact('dokumentasi', 'agendas'));
    }

    /**
     * Memperbarui data dokumentasi di database.
     */
    public function update(Request $request, Dokumentasi $dokumentasi)
    {
        $request->validate([
            'agenda_id' => 'required|exists:agendas,id',
            'caption' => 'nullable|string|max:255',
            'images' => 'nullable|array', // Gambar tidak wajib diisi saat update
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['agenda_id', 'caption']);

        if ($request->hasFile('images')) {
            $oldImages = json_decode($dokumentasi->image_path, true);
            if (is_array($oldImages)) {
                foreach ($oldImages as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('dokumentasi', 'public');
                $imagePaths[] = $path;
            }
            $data['image_path'] = json_encode($imagePaths);
        }

        $dokumentasi->update($data);

        return redirect()->route('dokumentasi.index')->with('success', 'Dokumentasi berhasil diperbarui.');
    }
    
    /**
     * Mengunduh semua gambar dokumentasi sebagai file ZIP.
     */
    public function download(Dokumentasi $dokumentasi)
    {
        $images = json_decode($dokumentasi->image_path, true);

        if (empty($images)) {
            return redirect()->back()->with('error', 'Tidak ada gambar untuk diunduh.');
        }

        // membuat nama file zip yang unik
        $zipFileName = 'dokumentasi-' . Str::slug($dokumentasi->agenda->title) . '-' . $dokumentasi->id . '.zip';
        $zipPath = storage_path('app/temp/' . $zipFileName);

        // memastikan direktori temp ada
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $zip = new \ZipArchive;

        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            foreach ($images as $imagePath) {
                if (Storage::disk('public')->exists($imagePath)) {
                    $absolutePath = Storage::disk('public')->path($imagePath);
                    $zip->addFile($absolutePath, basename($imagePath));
                }
            }
            $zip->close();
        } else {
            return redirect()->back()->with('error', 'Gagal membuat file zip.');
        }

        // mengembalikan file zip sebagai unduhan dan hapus setelah dikirim
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    /**
     * Menghapus dokumentasi dari database.
     */
    public function destroy(Dokumentasi $dokumentasi)
    {
        $imagePaths = json_decode($dokumentasi->image_path, true);

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