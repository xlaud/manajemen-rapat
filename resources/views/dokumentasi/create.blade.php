@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Unggah Dokumentasi Baru</h2>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dokumentasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        {{-- Pilihan Agenda --}}
        <div>
            <label for="agenda_id" class="block text-sm font-medium text-gray-700 mb-1">Agenda Terkait</label>
            <select name="agenda_id" id="agenda_id" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                <option value="">-- Pilih Agenda --</option>
                @foreach($agendas as $agenda)
                    <option value="{{ $agenda->id }}" {{ old('agenda_id') == $agenda->id ? 'selected' : '' }}>
                        {{ $agenda->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="caption" class="block text-sm font-medium text-gray-700 mb-1">Caption</label>
            <input type="text" name="caption" id="caption" value="{{ old('caption') }}"
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                   placeholder="Masukkan caption singkat untuk galeri ini">
        </div>

        <div>
            <label for="images" class="block text-sm font-medium text-gray-700 mb-1">File Dokumentasi (Bisa lebih dari satu)</label>
            <input type="file" name="images[]" id="images"
                   class="mt-1 block w-full text-sm text-gray-500
                          file:mr-4 file:py-2 file:px-4
                          file:rounded-full file:border-0
                          file:text-sm file:font-semibold
                          file:bg-blue-50 file:text-blue-700
                          hover:file:bg-blue-100"
                   multiple required>
            <p class="mt-1 text-xs text-gray-500">Max 2MB per file. Format: JPG, PNG, GIF, SVG.</p>
        </div>
        
        {{-- Tombol Aksi --}}
        <div class="flex space-x-3 pt-4">
            <button type="submit" class="flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-up"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M12 11V3"/><path d="m18 8-6-6-6 6"/></svg>
                <span>Unggah Dokumentasi</span>
            </button>
            <a href="{{ route('dokumentasi.index') }}" class="flex items-center space-x-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                <span>Batal</span>
            </a>
        </div>
    </form>
</div>
@endsection