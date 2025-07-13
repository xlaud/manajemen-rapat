@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Edit Dokumentasi</h2>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dokumentasi.update', $dokumentasi->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        {{-- Pilihan Agenda --}}
        <div>
            <label for="agenda_id" class="block text-sm font-medium text-gray-700 mb-1">Agenda Terkait</label>
            <select name="agenda_id" id="agenda_id" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                @foreach($agendas as $agenda)
                    <option value="{{ $agenda->id }}" {{ (old('agenda_id', $dokumentasi->agenda_id) == $agenda->id) ? 'selected' : '' }}>
                        {{ $agenda->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="caption" class="block text-sm font-medium text-gray-700 mb-1">Caption</label>
            <input type="text" name="caption" id="caption" value="{{ old('caption', $dokumentasi->caption) }}"
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                   placeholder="Masukkan caption singkat">
        </div>

        <div>
            <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Ganti File Dokumentasi (Opsional)</label>
            <input type="file" name="images[]" id="images"
                   class="mt-1 block w-full text-sm text-gray-500
                          file:mr-4 file:py-2 file:px-4
                          file:rounded-full file:border-0
                          file:text-sm file:font-semibold
                          file:bg-violet-50 file:text-violet-700
                          hover:file:bg-violet-100"
                   multiple>
            <p class="mt-1 text-xs text-gray-500">Pilih gambar baru untuk mengganti semua gambar lama. Max 2MB per file.</p>
        </div>
        
        <div class="flex space-x-3 pt-4">
            <button type="submit" class="flex items-center space-x-2 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md">
                <span>Perbarui Dokumentasi</span>
            </button>
            <a href="{{ route('dokumentasi.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md">
                <span>Batal</span>
            </a>
        </div>
    </form>
</div>
@endsection