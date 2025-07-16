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
<div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg">
    
    {{-- Header Halaman --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center sm:justify-between pb-6 border-b border-gray-200">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Rekapitulasi Presensi</h1>
            <p class="mt-1 text-sm text-gray-500">Lihat rekapitulasi kehadiran untuk setiap agenda rapat.</p>
        </div>
    </div>

    {{-- Pencarian Agenda --}}
    <div class="py-4">
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
                    class="block w-full py-2.5 pl-10 pr-3 text-gray-900 border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
                    value="{{ request('search') }}"
                >
            </div>
        </form>
    </div>

    {{-- Daftar Agenda (Accordion) --}}
    <div id="accordion-container" class="space-y-3">
        @forelse ($agendas as $agenda)
            <div class="accordion-item bg-white rounded-lg border border-gray-200 transition-shadow hover:shadow-md">
                <div class="accordion-header p-4 cursor-pointer flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-bold text-green-800">{{ $agenda->title }}</h2>
                        {{-- Informasi rekapitulasi presensi --}}
                        <div class="text-sm text-gray-500 mt-2 flex flex-wrap items-center gap-x-4 gap-y-2">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1.5 text-gray-400"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                {{ \Carbon\Carbon::parse($agenda->meeting_date)->translatedFormat('d F Y') }}
                            </span>
                            <div class="flex items-center space-x-4">
                                <span class="flex items-center font-medium text-green-700 text-xs">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1"><path d="M20 6 9 17l-5-5"/></svg>
                                    {{ $agenda->presensi->where('status', 'hadir')->count() }} Hadir
                                </span>
                                <span class="flex items-center font-medium text-yellow-600 text-xs">
                                     <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    {{ $agenda->presensi->where('status', 'izin')->count() }} Izin
                                </span>
                                <span class="flex items-center font-medium text-red-600 text-xs">
                                     <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                    {{ $agenda->presensi->where('status', 'tidak_hadir')->count() }} Tidak Hadir
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="toggle-button text-gray-500 hover:text-green-600 p-2 rounded-full">
                            <svg class="arrow-icon w-5 h-5 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="accordion-content">
                    <div class="p-4 sm:p-6 border-t border-gray-200">
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
            <div class="text-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 mx-auto mb-2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg>
                <p class="font-semibold text-gray-600">Tidak Ada Agenda</p>
                <p class="text-sm text-gray-500">Tidak ada agenda yang cocok dengan pencarian Anda.</p>
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
        const arrowIcon = item.find('.arrow-icon');
        const table = content.find('.presence-table');

        const isOpen = item.hasClass('is-open');

        // Tutup semua accordion lain
        $('.accordion-item.is-open').not(item).each(function() {
            $(this).removeClass('is-open');
            $(this).find('.accordion-content').css('max-height', '0px');
            $(this).find('.arrow-icon').removeClass('rotate-180');
        });

        // Buka atau tutup accordion yang diklik
        arrowIcon.toggleClass('rotate-180', !isOpen);
        item.toggleClass('is-open', !isOpen);

        if (!isOpen) {
            content.css('max-height', content[0].scrollHeight + 'px');

            // Inisialisasi DataTable jika belum ada
            if (table.length && !$.fn.dataTable.isDataTable(table)) {
                table.DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/2.0.8/i18n/id.json',
                    },
                    pageLength: 10,
                    searching: false, // Pencarian utama sudah ada di atas
                    lengthChange: false, // Sembunyikan pilihan jumlah entri
                    info: false, // Sembunyikan info "Showing x to y of z entries"
                    dom: "<'overflow-x-auto't><'pt-4'p>", // Hanya tabel dan paginasi
                });
            }
        } else {
            content.css('max-height', '0px');
        }
    });
});
</script>
@endpush
