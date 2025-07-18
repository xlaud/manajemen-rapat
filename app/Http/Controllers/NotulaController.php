<?php

namespace App\Http\Controllers;

use App\Models\Notula;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // <-- Tambahan penting
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Html;

class NotulaController extends Controller
{
    /**
     * Menampilkan daftar notula untuk Admin dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $notulas = Notula::query()
            ->with(['agenda', 'user']) // Eager load relasi agenda dan user
            ->latest()
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('agenda', function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%");
                    });
            })
            ->paginate(10);

        return view('notulas.index', compact('notulas'));
    }

    /**
     * Menampilkan daftar notula untuk Guru dengan fitur pencarian.
     */
    public function guruIndex(Request $request)
    {
        $search = $request->query('search');

        $notulas = Notula::query()
            ->with('agenda')
            ->latest()
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('agenda', function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%");
                    });
            })
            ->paginate(10);

        return view('notulas.guru_index', compact('notulas'));
    }

    /**
     * Menampilkan detail notula untuk Guru.
     */
    public function guruShow(Notula $notula)
    {
        $notula->load(['agenda', 'user']);
        return view('notulas.show', compact('notula'));
    }

    /**
     * Menampilkan form untuk membuat notula baru.
     */
    public function create()
    {
        // Ambil agenda yang belum memiliki notula untuk menghindari duplikasi
        $agendas = Agenda::whereDoesntHave('notula')->latest()->get();
        return view('notulas.create', ['notula' => new Notula(), 'agendas' => $agendas]);
    }

    /**
     * Menyimpan notula baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'agenda_id' => 'required|exists:agendas,id|unique:notulas,agenda_id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        Notula::create($data);

        return redirect()->route('notulas.index')->with('success', 'Notula berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit notula.
     */
    public function edit(Notula $notula)
    {
        if (Auth::user()->role !== 'admin' && Auth::id() !== $notula->user_id) {
            return redirect()->route('notulas.index')->with('error', 'Anda tidak memiliki izin untuk mengedit notula ini.');
        }

        $agendas = Agenda::latest()->get();
        return view('notulas.edit', compact('notula', 'agendas'));
    }

    /**
     * Memperbarui data notula di database.
     */
    public function update(Request $request, Notula $notula)
    {
        if (Auth::user()->role !== 'admin' && Auth::id() !== $notula->user_id) {
            return redirect()->route('notulas.index')->with('error', 'Anda tidak memiliki izin untuk memperbarui notula ini.');
        }

        $request->validate([
            'agenda_id' => 'required|exists:agendas,id|unique:notulas,agenda_id,' . $notula->id,
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $notula->update($request->all());

        return redirect()->route('notulas.index')->with('success', 'Notula berhasil diperbarui.');
    }

    /**
     * Menghapus notula dari database.
     */
    public function destroy(Notula $notula)
    {
        if (Auth::user()->role !== 'admin' && Auth::id() !== $notula->user_id) {
            return redirect()->route('notulas.index')->with('error', 'Anda tidak memiliki izin untuk menghapus notula ini.');
        }

        $notula->delete();

        return redirect()->route('notulas.index')->with('success', 'Notula berhasil dihapus.');
    }

    /**
     * Mengunduh notula sebagai file Word (.docx).
     */
    public function downloadWord(Notula $notula)
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Mengambil data relasi
        $notula->load('agenda');
        $agenda = $notula->agenda;

        // Menambahkan konten ke dokumen Word
        $section->addTitle($notula->title, 1);
        $section->addText("Agenda: " . ($agenda->title ?? 'Tidak ada agenda'), [], ['spaceAfter' => 200]);
        if ($agenda) {
            $section->addText("Tanggal Rapat: " . \Carbon\Carbon::parse($agenda->meeting_date)->translatedFormat('l, d F Y'));
        }
        $section->addTextBreak(1);

        // Mengonversi HTML ke format Word
        Html::addHtml($section, $notula->description);

        // Membuat nama file yang aman dan unik
        $fileName = 'notula-' . Str::slug($notula->title) . '-' . time() . '.docx';
        $tempPath = storage_path('app/temp/');

        // Memastikan direktori sementara ada
        if (!file_exists($tempPath)) {
            mkdir($tempPath, 0755, true);
        }

        $filePath = $tempPath . $fileName;

        // Menyimpan file dan mengirim sebagai respons unduhan
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}