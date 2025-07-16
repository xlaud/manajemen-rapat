@extends('layouts.app')

@section('content')
<div>
    {{-- ====================================================== --}}
    {{-- ====== 1. HEADER SAMBUTAN (UNTUK SEMUA USER) ====== --}}
    {{-- ====================================================== --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}!</h1>
        <p class="mt-1 text-lg text-gray-600">
            @if(Auth::user()->role === 'admin')
                Berikut adalah ringkasan data dari sistem manajemen rapat.
            @else
                Anda login sebagai Guru. Gunakan menu navigasi untuk mengakses fitur Anda.
            @endif
        </p>
    </div>

    {{-- ============================================================= --}}
    {{-- ====== 2. KARTU AGENDA TERDEKAT (UNTUK SEMUA USER) ====== --}}
    {{-- ============================================================= --}}
    <div class="mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-cyan-500">
            <h3 class="text-xl font-bold text-gray-800 mb-3 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3 text-cyan-600 lucide lucide-alarm-clock-check"><path d="M12 21a8 8 0 1 0-8-8"/><path d="M5 3 2 6"/><path d="m22 6-3-3"/><path d="M6.38 18.7 4 21"/><path d="M17.64 18.67 20 21"/><path d="m9 12 2 2 4-4"/><path d="M12 5v1"/></svg>
                Agenda Rapat Berikutnya
            </h3>

            @if(isset($agendaTerdekat))
                <p class="text-lg font-semibold text-cyan-800">{{ $agendaTerdekat->title }}</p>
                <div class="mt-2 text-gray-600 grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-1">
                    <p><strong><i class="lucide lucide-calendar-days" style="display: inline-block; width: 1em; height: 1em;"></i> Tanggal:</strong> {{ \Carbon\Carbon::parse($agendaTerdekat->meeting_date)->translatedFormat('l, d F Y') }}</p>
                    <p><strong><i class="lucide lucide-clock" style="display: inline-block; width: 1em; height: 1em;"></i> Jam:</strong> {{ \Carbon\Carbon::parse($agendaTerdekat->meeting_time)->format('H:i') }} WIB</p>
                </div>
            @else
                <p class="text-gray-500 italic">Tidak ada agenda rapat yang akan datang dalam waktu dekat. 🎉</p>
            @endif
        </div>
    </div>

    @if(Auth::user()->role === 'admin')
        {{-- BAGIAN INI HANYA MUNCUL JIKA USER ADALAH ADMIN --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">

            {{-- Kartu Total Agenda Rapat --}}
            <div class="bg-white p-6 rounded-2xl shadow-lg flex items-center space-x-4 transition-transform transform hover:scale-105">
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600 lucide lucide-calendar-days"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Agenda</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalAgendas ?? 0 }}</p>
                </div>
            </div>

            {{-- Kartu Total Notula --}}
            <div class="bg-white p-6 rounded-2xl shadow-lg flex items-center space-x-4 transition-transform transform hover:scale-105">
                <div class="bg-green-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600 lucide lucide-file-text"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Notula</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalNotulas ?? 0 }}</p>
                </div>
            </div>

            {{-- Kartu Total Guru --}}
            <div class="bg-white p-6 rounded-2xl shadow-lg flex items-center space-x-4 transition-transform transform hover:scale-105">
                <div class="bg-purple-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-purple-600 lucide lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Guru</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalGurus ?? 0 }}</p>
                </div>
            </div>

            {{-- Kartu Total Dokumentasi --}}
            <div class="bg-white p-6 rounded-2xl shadow-lg flex items-center space-x-4 transition-transform transform hover:scale-105">
                <div class="bg-yellow-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-600 lucide lucide-folder-open"><path d="M6 14.5V2a2 2 0 0 1 2-2h4l2 2h4a2 2 0 0 1 2 2v14.5A2.5 2 0 0 1 17.5 19H6a2.5 2 0 0 1-2.5-2.5V5.5L6 7z"/><path d="M10 12l2 2l4-4"/></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Dokumentasi</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalDokumentasi ?? 0 }}</p>
                </div>
            </div>

        </div>

    @elseif(Auth::user()->role === 'guru')
        {{-- BAGIAN INI HANYA MUNCUL JIKA USER ADALAH GURU --}}
        <div class="bg-white p-8 rounded-2xl shadow-lg">
            <h3 class="text-2xl font-semibold text-gray-800 mb-4">Informasi untuk Guru 🧑‍🏫</h3>
            <p class="text-gray-700 leading-relaxed">
                Selamat datang di halaman utama Anda. Halaman ini memberikan ringkasan cepat tentang agenda rapat yang akan datang. 
                <br><br>
                Untuk melihat daftar lengkap agenda, mengakses notula, atau mengisi presensi, silakan gunakan menu navigasi utama yang terletak di bagian atas halaman.
            </p>
        </div>
    @endif
</div>
@endsection
