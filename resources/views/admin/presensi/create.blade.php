@extends('layouts.app')

@section('content')

<div class="container p-6 mx-auto">

    <!-- Header dan Breadcrumb -->
    <div class="mb-6 bg-white rounded-sm shadow-sm">
        <div class="flex items-center justify-between p-6">
            <div>
                <h1 class="text-2xl font-bold text-purple-800 font-heading">
                    Presensi Manual
                </h1>
                <p class="mt-1 text-sm text-gray-600">
                    Mencatat kehadiran peserta secara manual sebagai alternatif apabila presensi QR atau wajah mengalami kendala
                </p>
            </div>
            <nav class="flex space-x-1 font-sans text-xs text-gray-500">
                <a href="{{ route('dashboard') }}"
                   class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">
                    Beranda
                </a>
                <span>/</span>
                <a href="{{ route('presensi.setting.page') }}" class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">Presensi</a>
                <span>/</span>
                <span class="text-gray-400">Presensi Manual</span>
            </nav>
        </div>
    </div>

    <!-- Form Card -->
    <div class="w-full p-6 mb-8 bg-white border border-gray-200 rounded-sm shadow-sm">

        <!-- Form Header -->
        <div class="pb-4 mb-6 border-b border-gray-200">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-purple-800 font-heading">
                        Pilih Peserta untuk Diabsen
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Cari dan klik tombol absen untuk mencatat kehadiran peserta
                    </p>
                </div>

                <a href="{{ route('presensi.setting.page') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold transition-all duration-300 border rounded-lg text-slate-700 bg-slate-50 border-slate-300 hover:bg-slate-100 hover:border-slate-400 hover:shadow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>


        <!-- Search Bar -->
        <div class="mb-6">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input
                    type="text"
                    id="search_peserta"
                    placeholder="Cari nama atau email peserta..."
                    class="w-full py-3 pl-12 pr-4 text-sm transition-all duration-200 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                    autocomplete="off"
                >
            </div>
        </div>

        <!-- Tabel Peserta -->
        <div class="overflow-x-auto border border-gray-200 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold tracking-wider text-left text-gray-700 uppercase">
                            No
                        </th>
                        <th class="px-6 py-3 text-xs font-semibold tracking-wider text-left text-gray-700 uppercase">
                            Nama Peserta
                        </th>
                        <th class="px-6 py-3 text-xs font-semibold tracking-wider text-center text-gray-700 uppercase">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="participant-list">
                    @forelse($participants as $index => $participant)
                        <tr class="transition-colors duration-200 participant-item hover:bg-purple-50"
                            data-name="{{ strtolower($participant->name) }}">
                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div>
                                        <div class="font-semibold text-gray-900">{{ $participant->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                @if ($activeSetting)
                                    @if ($participant->attendances->isNotEmpty())
                                        <!-- Sudah Presensi -->
                                        <div class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-green-700 bg-green-100 border border-green-300 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Sudah Presensi
                                        </div>
                                    @else
                                        <!-- Belum Presensi -->
                                        <form action="{{ route('presensi.manual.store') }}" method="POST" class="inline-block form-absen">
                                            @csrf
                                            <input type="hidden" name="participant_id" value="{{ $participant->id }}">

                                            <button
                                                type="submit"
                                                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white transition-all duration-200 bg-green-600 rounded-lg shadow-sm hover:bg-green-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Absen
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <!-- Presensi belum dibuka -->
                                    <span class="text-sm font-semibold text-gray-400">
                                        Presensi belum dibuka
                                    </span>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <p class="mt-4 text-gray-500">Belum ada data peserta</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- No Results Message -->
        <div id="no-results" class="hidden p-6 mt-4 border border-gray-200 rounded-lg">
            <div class="py-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="mt-4 text-gray-500">Tidak ada peserta ditemukan</p>
                <p class="mt-1 text-sm text-gray-400">Coba gunakan kata kunci lain</p>
            </div>
        </div>

        <!-- Info Alert -->
        <div class="p-4 mt-6 border-l-4 border-blue-500 rounded-r-lg bg-blue-50">
            <div class="flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-5 h-5 text-blue-600 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm text-blue-800">
                    <p class="font-semibold">Informasi:</p>
                    <ul class="mt-1 ml-4 space-y-1 list-disc">
                        <li>Klik tombol <strong>"Absen"</strong> untuk mencatat kehadiran peserta</li>
                        <li>Waktu presensi akan otomatis tercatat saat tombol diklik</li>
                        <li>Gunakan kolom pencarian untuk menemukan peserta dengan cepat</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

</div>

<script>

document.getElementById('search_peserta').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const participantRows = document.querySelectorAll('.participant-item');
    const noResults = document.getElementById('no-results');
    const table = document.querySelector('table');
    let visibleCount = 0;

    participantRows.forEach(row => {
        const name = row.dataset.name || '';

        if (name.includes(searchTerm)) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });


    if (visibleCount === 0 && searchTerm !== '') {
        noResults.classList.remove('hidden');
        table.classList.add('hidden');
    } else {
        noResults.classList.add('hidden');
        table.classList.remove('hidden');
    }
});


document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.form-absen').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const row = this.closest('tr');
            const participantName =
                row?.querySelector('.participant-name')?.textContent?.trim()
                || 'peserta ini';

            Swal.fire({
                title: 'Konfirmasi Presensi',
                html: `Yakin ingin mencatat kehadiran <b>${participantName}</b>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Absen',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#6b7280',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

@endsection
