@extends('layouts.app')

@section('content')
<div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg max-w-2xl mx-auto">
    <div class="text-center">
        <h1 class="text-2xl font-bold text-gray-800">Formulir Presensi</h1>
        <p class="text-gray-600 mt-1">Agenda Rapat:</p>
        {{-- Menampilkan judul agenda yang dikirim dari controller --}}
        <h2 class="text-3xl font-bold text-blue-600">{{ $agenda->title }}</h2>
    </div>

    <hr class="my-6">

    {{-- Jika guru sudah mengisi presensi, tampilkan pesan ini --}}
    @if($existingPresensi)
        <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 rounded-md" role="alert">
            <p class="font-bold">Terima Kasih!</p>
            <p>Anda sudah mencatat presensi untuk agenda ini pada tanggal {{ $existingPresensi->created_at->format('d F Y, H:i') }} dengan status: <span class="font-semibold capitalize">{{ str_replace('_', ' ', $existingPresensi->status) }}</span>.</p>
        </div>
        <div class="mt-6 text-center">
            <a href="{{ route('agendas.guru') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded-lg transition duration-300">
                Kembali ke Daftar Agenda
            </a>
        </div>
    @else
    {{-- Jika belum, tampilkan form untuk diisi --}}
        <form action="{{ route('presensi.store', $agenda) }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status Kehadiran Anda</label>
                <select id="status" name="status" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                    <option value="hadir">Hadir</option>
                    <option value="tidak_hadir">Tidak Hadir</option>
                    <option value="izin">Izin</option>
                </select>
            </div>
            <div>
                <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan (jika tidak hadir atau izin)</label>
                <textarea name="keterangan" id="keterangan" rows="3" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
            </div>
            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-300">
                    Kirim Presensi
                </button>
            </div>
        </form>
    @endif
</div>
@endsection