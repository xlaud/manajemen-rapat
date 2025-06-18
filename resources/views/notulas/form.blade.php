{{-- resources/views/notulas/form.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">{{ $mode === 'create' ? 'Tambah Notula Baru' : 'Edit Notula' }}</h2>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $mode === 'create' ? route('notulas.store') : route('notulas.update', $notula->id) }}" method="POST" class="space-y-4">
        @csrf
        @if($mode === 'edit')
            @method('PUT')
        @endif
        
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Notula</label>
            <input type="text" name="title" id="title" value="{{ old('title', $notula->title ?? '') }}"
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                   placeholder="Masukkan judul notula" required>
        </div>
        <div>
            <label for="agenda_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Agenda Rapat</label>
            <select name="agenda_id" id="agenda_id" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                <option value="">-- Pilih Agenda --</option>
                @foreach($agendas as $agenda)
                    <option value="{{ $agenda->id }}" {{ (old('agenda_id', $notula->agenda_id ?? '') == $agenda->id) ? 'selected' : '' }}>
                        {{ $agenda->title }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Isi Notula</label>
            <textarea name="description" id="description" rows="10"
                      class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                      placeholder="Tulis isi notula rapat di sini...">{{ old('description', $notula->description ?? '') }}</textarea>
        </div>
        
        <div class="flex space-x-3">
            <button type="submit" class="flex items-center space-x-2 bg-{{ $mode === 'create' ? 'green' : 'yellow' }}-600 hover:bg-{{ $mode === 'create' ? 'green' : 'yellow' }}-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                <span>{{ $mode === 'create' ? 'Simpan Notula' : 'Perbarui Notula' }}</span>
            </button>
            <a href="{{ route('notulas.index') }}" class="flex items-center space-x-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                <span>Batal</span>
            </a>
        </div>
    </form>
</div>
@endsection
