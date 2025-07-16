@extends('layouts.app')

@push('styles')
<style>
    /* Style untuk radio button kustom */
    .radio-card input[type="radio"] {
        display: none;
    }
    .radio-card .radio-label {
        display: block;
        cursor: pointer;
        border: 2px solid #E5E7EB; /* border-gray-200 */
        padding: 1rem;
        border-radius: 0.75rem; /* rounded-xl */
        transition: all 0.2s ease-in-out;
        text-align: center;
    }
    .radio-card .radio-label:hover {
        border-color: #10B981; /* border-emerald-500 */
    }
    .radio-card input[type="radio"]:checked + .radio-label {
        border-color: #059669; /* border-green-600 */
        background-color: #D1FAE5; /* bg-green-100 */
        color: #047857; /* text-green-800 */
        font-weight: 600;
    }
    .radio-card input[type="radio"]:checked + .radio-label svg {
        stroke: #059669;
    }
    #keterangan-container {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease-in-out;
    }
</style>
@endpush

@section('content')
<div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg max-w-3xl mx-auto">
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-800">Formulir Presensi</h1>
        <p class="mt-2 text-gray-600">Anda akan mengisi presensi untuk rapat:</p>
        <p class="text-xl font-semibold text-green-700 mt-1">{{ $agenda->title }}</p>
        <p class="text-sm text-gray-500 mt-1">{{ \Carbon\Carbon::parse($agenda->meeting_date)->translatedFormat('l, d F Y') }}</p>
    </div>

    @include('components.message')

    {{-- Cek apakah guru sudah pernah mengisi presensi --}}
    @if($existingPresensi)
        <div class="bg-green-50 border-l-4 border-green-400 text-green-800 p-4 rounded-r-md" role="alert">
            <p class="font-bold">Presensi Tercatat</p>
            <p>Anda sudah mencatat presensi untuk rapat ini pada tanggal {{ $existingPresensi->created_at->format('d/m/Y \p\u\k\u\l H:i') }} dengan status <span class="font-semibold capitalize">{{ str_replace('_', ' ', $existingPresensi->status) }}</span>.</p>
            <a href="{{ route('agendas.guru') }}" class="inline-block mt-3 text-sm font-medium text-green-700 hover:text-green-900">← Kembali ke Daftar Agenda</a>
        </div>
    @else
        {{-- Jika belum, tampilkan formulir --}}
        <form action="{{ route('presensi.store', ['agenda' => $agenda->id]) }}" method="POST">
            @csrf
            <div class="space-y-6">
                <fieldset>
                    <legend class="block text-sm font-medium text-gray-700 mb-2 text-center">Pilih Status Kehadiran Anda</legend>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="radio-card">
                            <input type="radio" id="hadir" name="status" value="hadir" required>
                            <label for="hadir" class="radio-label flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-2 text-gray-400"><path d="M20 6 9 17l-5-5"/></svg>
                                <span>Hadir</span>
                            </label>
                        </div>
                        <div class="radio-card">
                            <input type="radio" id="izin" name="status" value="izin">
                            <label for="izin" class="radio-label flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-2 text-gray-400"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                <span>Izin</span>
                            </label>
                        </div>
                        <div class="radio-card">
                            <input type="radio" id="tidak_hadir" name="status" value="tidak_hadir">
                            <label for="tidak_hadir" class="radio-label flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-2 text-gray-400"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                <span>Tidak Hadir</span>
                            </label>
                        </div>
                    </div>
                </fieldset>

                <div id="keterangan-container">
                    <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan (wajib diisi jika Izin atau Tidak Hadir)</label>
                    <div class="mt-1">
                        <textarea name="keterangan" id="keterangan" rows="3" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"></textarea>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-lg shadow-md transition-colors">
                        Kirim Presensi
                    </button>
                </div>
            </div>
        </form>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const statusRadios = document.querySelectorAll('input[name="status"]');
    const keteranganContainer = document.getElementById('keterangan-container');
    const keteranganTextarea = document.getElementById('keterangan');

    function toggleKeterangan() {
        const selectedStatus = document.querySelector('input[name="status"]:checked');
        if (selectedStatus && (selectedStatus.value === 'izin' || selectedStatus.value === 'tidak_hadir')) {
            keteranganContainer.style.maxHeight = keteranganContainer.scrollHeight + 'px';
            keteranganTextarea.required = true;
        } else {
            keteranganContainer.style.maxHeight = '0';
            keteranganTextarea.required = false;
        }
    }

    statusRadios.forEach(radio => {
        radio.addEventListener('change', toggleKeterangan);
    });

    // Panggil sekali saat load untuk handle kasus edit atau error validation
    toggleKeterangan();
});
</script>
@endpush
