@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-lg max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Formulir Presensi</h1>
        <p class="mt-1 text-gray-600">Anda akan mengisi presensi untuk rapat: <span class="font-semibold">{{ $agenda->title }}</span></p>
        <p class="text-sm text-gray-500">Tanggal: {{ \Carbon\Carbon::parse($agenda->meeting_date)->translatedFormat('l, d F Y') }}</p>
    </div>

    @include('components.message')

    {{-- Cek apakah guru sudah pernah mengisi presensi --}}
    @if($existingPresensi)
        <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-700 p-4 rounded-md" role="alert">
            <p class="font-bold">Informasi</p>
            <p>Anda sudah mencatat presensi untuk rapat ini pada tanggal {{ $existingPresensi->created_at->format('d/m/Y \p\u\k\u\l H:i') }} dengan status <span class="font-semibold capitalize">{{ str_replace('_', ' ', $existingPresensi->status) }}</span>.</p>
        </div>
    @else
        {{-- Jika belum, tampilkan formulir --}}
        <form action="{{ route('presensi.store', $agenda->id) }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status Kehadiran</label>
                    <div class="mt-2 space-y-2">
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio" name="status" value="hadir" required>
                            <span class="ml-2">Hadir</span>
                        </label>
                        <label class="inline-flex items-center ml-6">
                            <input type="radio" class="form-radio" name="status" value="izin">
                            <span class="ml-2">Izin</span>
                        </label>
                        <label class="inline-flex items-center ml-6">
                            <input type="radio" class="form-radio" name="status" value="tidak_hadir">
                            <span class="ml-2">Tidak Hadir</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan (jika Izin atau Tidak Hadir)</label>
                    <div class="mt-1">
                        <textarea name="keterangan" id="keterangan" rows="3" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm"></textarea>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md">
                        Kirim Presensi
                    </button>
                </div>
            </div>
        </form>
    @endif
</div>
@endsection
