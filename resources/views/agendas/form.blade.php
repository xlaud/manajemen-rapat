@extends('layouts.app')

@section('content')
    @php
        // Menentukan mode form (create atau edit) untuk judul, rute, dan tombol
        $isEdit = isset($agenda);
        $title = $isEdit ? 'Edit Agenda Rapat' : 'Tambah Agenda Baru';

        // ========================================================================
        // ====== INILAH BARIS KODE YANG MEMPERBAIKI ERROR ANDA ======
        //
        // Saat mengedit, kita harus memberitahu Laravel nama parameter ('agenda')
        // yang akan diisi dengan ID.
        //
        // Kode Lama (Salah): route('agendas.update', $agenda->id)
        // Kode Baru (Benar): route('agendas.update', ['agenda' => $agenda->id])
        // ========================================================================
        $route = $isEdit ? route('agendas.update', ['agenda' => $agenda->id]) : route('agendas.store');
    @endphp

    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg max-w-3xl mx-auto">
        {{-- Header Halaman --}}
        <div class="mb-8 pb-6 border-b border-gray-200">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $title }}</h1>
            <p class="mt-1 text-sm text-gray-500">
                @if ($isEdit)
                    Perbarui detail untuk agenda: <span class="font-semibold">{{ $agenda->title }}</span>.
                @else
                    Isi formulir di bawah ini untuk menjadwalkan rapat baru.
                @endif
            </p>
        </div>

        {{-- Notifikasi Error --}}
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-400 text-red-800 p-4 mb-6 rounded-r-md" role="alert">
                <p class="font-bold mb-2">Terjadi kesalahan:</p>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $route }}" method="POST" class="space-y-6">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            {{-- Judul Agenda --}}
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Agenda</label>
                <input type="text" name="title" id="title" value="{{ old('title', $agenda->title ?? '') }}"
                    class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
                    placeholder="Contoh: Rapat Persiapan Ujian Akhir Semester" required>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi / Detail
                    Pembahasan</label>
                <textarea name="description" id="description" rows="5"
                    class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
                    placeholder="Masukkan detail atau topik yang akan dibahas...">{{ old('description', $agenda->description ?? '') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Tanggal Rapat --}}
                <div>
                    <label for="meeting_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Rapat</label>
                    <input type="date" name="meeting_date" id="meeting_date"
                        value="{{ old('meeting_date', $agenda->meeting_date?->format('Y-m-d')) }}"
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
                        required>
                </div>

                {{-- Waktu Rapat --}}
                <div>
                    <label for="meeting_time" class="block text-sm font-medium text-gray-700 mb-1">Waktu Rapat</label>
                    <input type="time" name="meeting_time" id="meeting_time"
                        value="{{ old('meeting_time', $agenda->meeting_time?->format('H:i')) }}"
                        class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
                        required>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end space-x-4 pt-4">
                <a href="{{ route('agendas.index') }}"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-2.5 px-6 rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-md transition-colors">
                    {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Agenda' }}
                </button>
            </div>
        </form>
    </div>
@endsection
