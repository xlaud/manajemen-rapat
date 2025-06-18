@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
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

    <form action="{{ route('dokumentasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Dokumentasi</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}"
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                   placeholder="Masukkan judul dokumentasi" required>
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <textarea name="description" id="description" rows="5"
                      class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                      placeholder="Masukkan deskripsi dokumentasi">{{ old('description') }}</textarea>
        </div>
        <div>
            <label for="file" class="block text-sm font-medium text-gray-700 mb-1">File Dokumentasi (PDF, DOC, Gambar)</label>
            <input type="file" name="file" id="file"
                   class="mt-1 block w-full text-sm text-gray-500
                   file:mr-4 file:py-2 file:px-4
                   file:rounded-full file:border-0
                   file:text-sm file:font-semibold
                   file:bg-violet-50 file:text-violet-700
                   hover:file:bg-violet-100">
            <p class="mt-1 text-xs text-gray-500">Max 5MB. Format: PDF, DOCX, PPTX, JPG, PNG.</p>
        </div>
        <div>
            <label for="agenda_id" class="block text-sm font-medium text-gray-700 mb-1">Agenda Terkait (Opsional)</label>
            <select name="agenda_id" id="agenda_id" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="">-- Pilih Agenda --</option>
                @foreach($agendas as $agenda)
                    <option value="{{ $agenda->id }}" {{ old('agenda_id') == $agenda->id ? 'selected' : '' }}>
                        {{ $agenda->title }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="flex space-x-3">
            <button type="submit" class="flex items-center space-x-2 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                <span>Unggah Dokumentasi</span>
            </button>
            <a href="{{ route('dokumentasi.index') }}" class="flex items-center space-x-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                <span>Batal</span>
            </a>
        </div>
    </form>
</div>
@endsection
