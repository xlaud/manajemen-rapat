@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-3xl font-bold text-gray-800 mb-4">Selamat Datang!</h2>
    <p class="text-lg text-gray-700">
        Anda berhasil masuk ke Sistem Manajemen Rapat Guru SMPN 3 Mojosongo.
    </p>
    <p class="text-md text-gray-600 mt-2">
        ID Pengguna Anda: <span class="font-semibold text-blue-600">{{ Auth::user()->id ?? 'N/A' }}</span>
    </p>
    <p class="text-md text-gray-600">
        Peran Anda: <span class="font-semibold text-purple-600 capitalize">{{ Auth::user()->role ?? 'N/A' }}</span>
    </p>

    @if((Auth::user()->role ?? '') === 'admin')
        <div class="mt-8">
            <h3 class="text-2xl font-semibold text-gray-800 mb-3">Fitur Admin:</h3>
            <ul class="list-disc list-inside text-gray-700 space-y-2">
                <li>Mengelola data guru (CRUD)</li>
                <li>Mengelola agenda rapat (CRUD)</li>
                <li>Mengelola presensi (CRUD)</li>
                <li>Mengelola notula (CRUD)</li>
                <li>Mengelola dokumentasi rapat (CRUD)</li>
            </ul>
            <p class="mt-4 text-gray-600">
                Gunakan navigasi di atas untuk mengakses berbagai modul manajemen.
            </p>
        </div>
    @elseif((Auth::user()->role ?? '') === 'guru')
        <div class="mt-8">
            <h3 class="text-2xl font-semibold text-gray-800 mb-3">Fitur Guru:</h3>
            <ul class="list-disc list-inside text-gray-700 space-y-2">
                <li>Melihat agenda rapat</li>
                <li>Mengisi presensi</li>
                <li>Melihat notula rapat</li>
            </ul>
            <p class="mt-4 text-gray-600">
                Gunakan navigasi di atas untuk melihat agenda, mengisi presensi, dan melihat notula.
            </p>
        </div>
    @endif
</div>
@endsection
