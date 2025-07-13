@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md max-w-4xl mx-auto">
    {{-- Header Notula --}}
    <div class="border-b pb-4 mb-6">
        <h1 class="text-3xl font-bold text-gray-800">{{ $notula->title }}</h1>
        <div class="mt-2 text-sm text-gray-500">
            <p><strong>Agenda:</strong> {{ $notula->agenda->title ?? 'N/A' }}</p>
            <p><strong>Tanggal Rapat:</strong> {{ \Carbon\Carbon::parse($notula->agenda->meeting_date)->translatedFormat('l, d F Y') }}</p>
            <p><strong>Notulis:</strong> {{ $notula->user->name ?? 'N/A' }}</p>
        </div>
    </div>

    {{-- Isi Notula --}}
    <div class="prose max-w-none text-gray-700">
        {!! nl2br(e($notula->description)) !!}
    </div>

    {{-- Tombol Kembali --}}
    <div class="mt-8">
        <a href="{{ route('notulas.guru') }}" class="text-blue-600 hover:underline">
            &larr; Kembali ke Daftar Notula
        </a>
    </div>
</div>

{{-- Styling untuk konten dari notula --}}
<style>
    .prose p {
        margin-bottom: 1em;
    }
    .prose ul, .prose ol {
        margin-left: 1.5em;
        margin-bottom: 1em;
    }
    .prose li {
        margin-bottom: 0.5em;
    }
</style>
@endsection