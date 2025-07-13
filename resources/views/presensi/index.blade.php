@extends('layouts.app')

{{-- Menambahkan style untuk animasi accordion --}}
@push('styles')
<style>
    /* Mengatur transisi untuk max-height agar animasi berjalan mulus */
    .accordion-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-in-out;
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    {{-- Header Halaman --}}
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Rekapitulasi Presensi</h1>
            <p class="mt-1 text-sm text-gray-500">Lihat rekapitulasi kehadiran untuk setiap agenda rapat.</p>
        </div>
    </div>

    {{-- 1. FORM PENCARIAN --}}
    <div class="mt-4">
        <form action="{{ route('presensi.index') }}" method="GET" class="w-full">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </span>
                <input 
                    type="search" 
                    name="search" 
                    placeholder="Cari agenda rapat..." 
                    class="block w-full py-2 pl-10 pr-3 text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    value="{{ request('search') }}"
                >
            </div>
        </form>
    </div>

    {{-- Daftar Agenda (Accordion) --}}
    <div id="accordion-container" class="space-y-4">
        @forelse ($agendas as $agenda)
            <div class="accordion-item bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">
                <div class="accordion-header bg-gray-50 hover:bg-gray-100 p-4 cursor-pointer flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold text-blue-600">{{ $agenda->title }}</h2>
                        <p class="text-sm text-gray-500">
                            Tanggal: <span class="font-medium">{{ \Carbon\Carbon::parse($agenda->meeting_date)->translatedFormat('d F Y') }}</span>
                            <span class="mx-2">|</span>
                            Jumlah Hadir: <span class="font-medium">{{ $agenda->presensi->count() }}</span>
                        </p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="toggle-button bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-bold py-2 px-3 rounded-lg flex items-center space-x-2">
                            <span class="button-text">Lihat Detail</span>
                            <svg class="arrow-icon w-4 h-4 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="accordion-content">
                    <div class="p-6 border-t border-gray-200">
                        <div class="overflow-x-auto">
                            <table class="presence-table min-w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama Guru</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Waktu Mengisi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse ($agenda->presensi as $p)
                                        <tr>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $p->user->name ?? 'User tidak ditemukan' }}</td>
                                            <td class="px-4 py-3">
                                                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full capitalize
                                                    {{ $p->status == 'hadir' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $p->status == 'tidak_hadir' ? 'bg-red-100 text-red-800' : '' }}
                                                    {{ $p->status == 'izin' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                                    {{ str_replace('_', ' ', $p->status) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-500">{{ $p->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-4 py-6 text-center text-gray-500">
                                                Belum ada data presensi untuk agenda ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white p-8 rounded-2xl shadow-lg text-center">
                <p class="text-gray-500">Tidak ada agenda yang cocok dengan pencarian Anda.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $agendas->appends(request()->query())->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.accordion-header').on('click', function() {
        const item = $(this).closest('.accordion-item');
        const content = item.find('.accordion-content');
        const buttonText = item.find('.button-text');
        const arrowIcon = item.find('.arrow-icon');
        const table = content.find('.presence-table');

        const isOpen = item.hasClass('is-open');

        arrowIcon.toggleClass('rotate-180', !isOpen);
        buttonText.text(isOpen ? 'Lihat Detail' : 'Sembunyikan');
        item.toggleClass('is-open', !isOpen);

        if (!isOpen) {
            content.css('max-height', content[0].scrollHeight + 'px');

            if (table.length && !$.fn.dataTable.isDataTable(table)) {
                table.DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/2.0.8/i18n/id.json',
                    },
                    pageLength: 10,
                    dom: "<'sm:flex items-center justify-between mb-4'<'w-full sm:w-auto'l><'w-full sm:w-auto'f>>" +
                         "<'overflow-x-auto't>" +
                         "<'sm:flex items-center justify-between mt-4'<'w-full sm:w-auto'i><'w-full sm:w-auto'p>>",
                });
            }
        } else {
            content.css('max-height', '0px');
        }
    });
});
</script>
@endpush
