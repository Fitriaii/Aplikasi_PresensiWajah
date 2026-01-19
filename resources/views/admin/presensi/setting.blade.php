@extends('layouts.app')

@section('content')
<div class="container p-6 mx-auto">
    <!-- Header dan Breadcrumb -->
    <div class="mb-6 bg-white rounded-sm shadow-sm">
        <div class="flex items-center justify-between p-6">
            <div>
                <h1 class="text-2xl font-bold text-purple-800 font-heading">
                    Pengaturan Presensi Event
                </h1>
                <p class="mt-1 text-sm text-gray-600">
                    Atur waktu dan kelola metode presensi peserta
                </p>
            </div>
            <nav class="flex space-x-1 font-sans text-xs text-gray-500">
                <a href="{{ route('dashboard') }}"
                   class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">
                    Beranda
                </a>
                <span>/</span>
                <span class="text-gray-400">Data Presensi</span>
            </nav>
        </div>
    </div>

    <div class="w-full p-6 mb-8 bg-white border border-gray-200 rounded-sm shadow-sm">
        <!-- Form Header -->
        <div class="pb-4 mb-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-purple-800 font-heading">
                Pengaturan Waktu Presensi
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Presensi hanya bisa dilakukan sesuai waktu yang ditentukan
            </p>
        </div>

        @php
            // Cek apakah presensi sudah expired
            $isExpired = false;
            if ($presensi && $presensi->end_time) {
                $isExpired = \Carbon\Carbon::parse($presensi->end_time)->isPast();
            }

            // Cek apakah presensi belum dimulai
            $isUpcoming = false;
            if ($presensi && $presensi->start_time) {
                $isUpcoming = \Carbon\Carbon::parse($presensi->start_time)->isFuture();
            }
        @endphp

        <!-- Warning jika event expired -->
        @if ($presensiAktif && $isExpired)
            <div class="p-4 mb-6 border-l-4 border-orange-500 bg-orange-50">
                <div class="flex items-start">
                    <svg class="w-5 h-5 mt-0.5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-orange-800">Event Sudah Berakhir</p>
                        <p class="mt-1 text-sm text-orange-700">
                            Waktu presensi telah berakhir pada {{ \Carbon\Carbon::parse($presensi->end_time)->format('d M Y, H:i') }}.
                            Sistem akan otomatis menonaktifkan presensi ini.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('presensi.setting') }}">
            @csrf
            <div class="grid gap-6 md:grid-cols-3">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        Waktu Mulai <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local"
                        name="start_time"
                        value="{{ old('start_time', $presensi ? \Carbon\Carbon::parse($presensi->start_time)->format('Y-m-d\TH:i') : '') }}"
                        {{ $presensiAktif ? 'readonly' : '' }}
                        class="block w-full px-4 py-3 transition-colors border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 {{ $presensiAktif ? 'bg-gray-50 cursor-not-allowed text-gray-500' : 'bg-white' }}"
                        required>
                    @error('start_time')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        Waktu Selesai <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local"
                        name="end_time"
                        value="{{ old('end_time', $presensi ? \Carbon\Carbon::parse($presensi->end_time)->format('Y-m-d\TH:i') : '') }}"
                        {{ $presensiAktif ? 'readonly' : '' }}
                        class="block w-full px-4 py-3 transition-colors border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 {{ $presensiAktif ? 'bg-gray-50 cursor-not-allowed text-gray-500' : 'bg-white' }}"
                        required>
                    @error('end_time')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-end">
                    @if (!$presensiAktif)
                        <button type="submit"
                            class="w-full px-6 py-3 font-semibold text-white transition-all duration-200 transform bg-green-600 rounded-lg shadow-md hover:bg-green-700 hover:shadow-lg hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Aktifkan Presensi
                            </span>
                        </button>
                    @else
                        <button type="button" disabled
                            class="w-full px-6 py-3 font-semibold text-white bg-gray-400 rounded-lg shadow cursor-not-allowed">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Presensi Aktif
                            </span>
                        </button>
                    @endif
                </div>
            </div>
        </form>

        @if ($presensiAktif)
            @if ($isExpired)
                <!-- Event Expired Status -->
                <div class="p-6 mt-10 mb-10 border-2 border-red-200 rounded-lg bg-gradient-to-r from-red-50 to-rose-50">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-start gap-4">
                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 bg-red-100 rounded-xl">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-red-800">
                                    Event Presensi Sudah Berakhir
                                </h4>
                                <p class="flex items-center gap-2 mt-1 text-sm font-medium text-red-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Berakhir: {{ \Carbon\Carbon::parse($presensi->end_time)->format('d M Y, H:i') }}
                                </p>
                                <p class="mt-2 text-xs text-red-600">
                                    {{ \Carbon\Carbon::parse($presensi->end_time)->diffForHumans() }}
                                </p>
                            </div>
                        </div>

                        <form method="POST"
                            action="{{ route('presensi.nonaktif') }}"
                            onsubmit="return confirmMatikanPresensi(this)">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-2 px-6 py-2.5 text-sm font-semibold text-white transition-all duration-200 bg-red-600 rounded-lg shadow-md hover:bg-red-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Matikan Presensi
                            </button>
                        </form>
                    </div>
                </div>
            @elseif ($isUpcoming)
                <!-- Upcoming Event Status -->
                <div class="p-6 mt-10 mb-10 border-2 border-blue-200 rounded-lg bg-gradient-to-r from-blue-50 to-cyan-50">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-start gap-4">
                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 bg-blue-100 rounded-xl">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-blue-800">
                                    Presensi Akan Segera Dimulai
                                </h4>
                                <p class="flex items-center gap-2 mt-1 text-sm font-medium text-blue-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($presensi->start_time)->format('d M Y, H:i') }} – {{ \Carbon\Carbon::parse($presensi->end_time)->format('H:i') }}
                                </p>
                                <p class="mt-2 text-xs text-blue-600">
                                    Mulai {{ \Carbon\Carbon::parse($presensi->start_time)->diffForHumans() }}
                                </p>
                            </div>
                        </div>

                        <form method="POST"
                            action="{{ route('presensi.nonaktif') }}"
                            onsubmit="return confirmBatalkanPresensi(this)">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-2 px-6 py-2.5 text-sm font-semibold text-white transition-all duration-200 bg-red-600 rounded-lg shadow-md hover:bg-red-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Batalkan Presensi
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <!-- Active Event Status -->
                <div class="p-6 mt-10 mb-10 border-2 border-green-200 rounded-lg bg-gradient-to-r from-green-50 to-emerald-50">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-start gap-4">
                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 bg-green-100 rounded-xl">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-green-800">
                                    Presensi Sedang Aktif
                                </h4>
                                <p class="flex items-center gap-2 mt-1 text-sm font-medium text-green-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($presensi->start_time)->format('d M Y, H:i') }} – {{ \Carbon\Carbon::parse($presensi->end_time)->format('H:i') }}
                                </p>
                                <p class="mt-2 text-xs text-green-600">
                                    Berakhir {{ \Carbon\Carbon::parse($presensi->end_time)->diffForHumans() }}
                                </p>
                            </div>
                        </div>

                        <form method="POST"
                            action="{{ route('presensi.nonaktif') }}"
                            onsubmit="return confirmMatikanPresensi(this)">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-2 px-6 py-2.5 text-sm font-semibold text-white transition-all duration-200 bg-red-600 rounded-lg shadow-md hover:bg-red-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Matikan Presensi
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Form Header 2 -->
            <div class="pb-4 mb-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-purple-800 font-heading">
                    Kelola Metode Presensi
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Admin dapat menggunakan presensi manual untuk mencatat kehadiran peserta
                </p>
            </div>

            <!-- ACTION BUTTON -->
            <div class="mt-6">
                <a href="{{ route('presensi.manual') }}"
                    class="inline-flex items-center justify-center gap-3 px-8 py-4 font-semibold text-white transition-all duration-200 transform bg-blue-600 rounded-xl shadow-md hover:bg-blue-700 hover:shadow-lg hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 {{ $isExpired ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Presensi Manual
                </a>
            </div>
        @endif

        {{-- LOG / HISTORY PRESENSI --}}
        <div class="mt-14">
            <div class="pb-4 mb-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-purple-800 font-heading">
                    Riwayat Pengaturan Presensi
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Daftar histori waktu presensi yang pernah diaktifkan
                </p>
            </div>

            <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr class="text-left text-gray-600">
                                <th class="px-4 py-3 font-semibold">No</th>
                                <th class="px-4 py-3 font-semibold">Waktu Mulai</th>
                                <th class="px-4 py-3 font-semibold">Waktu Selesai</th>
                                <th class="px-4 py-3 font-semibold">Durasi</th>
                                <th class="px-4 py-3 font-semibold">Status Aktif</th>
                                <th class="px-4 py-3 font-semibold">Tanggal Dibuat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($presensiLog as $item)
                                @php
                                    $itemIsExpired = \Carbon\Carbon::parse($item->end_time)->isPast();
                                    $itemIsUpcoming = \Carbon\Carbon::parse($item->start_time)->isFuture();
                                    $itemIsOngoing = !$itemIsExpired && !$itemIsUpcoming;

                                    $startTime = \Carbon\Carbon::parse($item->start_time);
                                    $endTime = \Carbon\Carbon::parse($item->end_time);
                                    $duration = $startTime->diffForHumans($endTime, true);
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-gray-700">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-700">
                                        {{ $startTime->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-700">
                                        {{ $endTime->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">
                                        {{ $duration }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($item->is_active)
                                            <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold text-gray-600 bg-gray-100 rounded-full">
                                                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">
                                        {{ $item->created_at->format('d M Y H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                            <p class="font-medium">Belum ada riwayat pengaturan presensi</p>
                                            <p class="text-xs text-gray-400">Aktifkan presensi untuk mulai mencatat kehadiran</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@if (session('status') && session('message'))
<script>
    Swal.fire({
        icon: @json(session('status')),
        title: @json(
            session('status') === 'success' ? 'Berhasil' :
            (session('status') === 'error' ? 'Gagal' : 'Informasi')
        ),
        text: @json(session('message')),
        showConfirmButton: @json(session('status') !== 'success'),
        timer: @json(session('status') === 'success' ? 2000 : null),
        confirmButtonColor: '#10b981'
    });
</script>
@endif

<script>
    // Function untuk konfirmasi matikan presensi
    function confirmMatikanPresensi(form) {
        event.preventDefault();

        Swal.fire({
            title: 'Matikan Presensi?',
            html: `
                <div class="text-left">
                    <p class="mb-3 text-gray-700">Apakah Anda yakin ingin mematikan presensi?</p>
                    <div class="p-3 mb-3 border-l-4 border-yellow-400 bg-yellow-50">
                        <p class="text-sm text-yellow-800">
                            <strong>⚠️ Perhatian:</strong>
                        </p>
                        <ul class="mt-2 ml-4 text-sm text-yellow-700 list-disc">
                            <li>Presensi akan dinonaktifkan</li>
                            <li>Peserta tidak dapat melakukan presensi</li>
                            <li>Data yang sudah tercatat tetap tersimpan</li>
                        </ul>
                    </div>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Matikan',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Memproses...',
                    html: 'Sedang mematikan presensi',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Submit form
                form.submit();
            }
        });

        return false;
    }

    // Function untuk konfirmasi batalkan presensi
    function confirmBatalkanPresensi(form) {
        event.preventDefault();

        Swal.fire({
            title: 'Batalkan Presensi?',
            html: `
                <div class="text-left">
                    <p class="mb-3 text-gray-700">Apakah Anda yakin ingin membatalkan presensi yang akan datang?</p>
                    <div class="p-3 mb-3 border-l-4 border-blue-400 bg-blue-50">
                        <p class="text-sm text-blue-800">
                            <strong>ℹ️ Informasi:</strong>
                        </p>
                        <ul class="mt-2 ml-4 text-sm text-blue-700 list-disc">
                            <li>Presensi akan dibatalkan</li>
                            <li>Jadwal yang sudah diatur akan dihapus</li>
                            <li>Anda dapat mengatur ulang jadwal baru</li>
                        </ul>
                    </div>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Batalkan',
            cancelButtonText: 'Tidak',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Memproses...',
                    html: 'Sedang membatalkan presensi',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Submit form
                form.submit();
            }
        });

        return false;
    }

    // Auto hide expired warning
    @if($presensiAktif && $isExpired)
        setTimeout(() => {
            Swal.fire({
                title: 'Presensi Sudah Berakhir',
                html: `
                    <div class="text-left">
                        <p class="mb-3 text-gray-700">Event presensi telah melewati waktu yang ditentukan.</p>
                        <div class="p-3 border-l-4 border-orange-400 bg-orange-50">
                            <p class="text-sm text-orange-800">
                                <strong>📅 Waktu Berakhir:</strong><br>
                                {{ \Carbon\Carbon::parse($presensi->end_time)->format('d M Y, H:i') }}
                            </p>
                            <p class="mt-2 text-xs text-orange-600">
                                {{ \Carbon\Carbon::parse($presensi->end_time)->diffForHumans() }}
                            </p>
                        </div>
                        <p class="mt-3 text-sm text-gray-600">
                            Silakan matikan presensi ini untuk mengatur jadwal baru.
                        </p>
                    </div>
                `,
                icon: 'info',
                confirmButtonText: 'Mengerti',
                confirmButtonColor: '#f59e0b'
            });
        }, 1000);
    @endif

    // Welcome message untuk upcoming event
    @if($presensiAktif && $isUpcoming)
        setTimeout(() => {
            Swal.fire({
                title: 'Presensi Terjadwal',
                html: `
                    <div class="text-left">
                        <p class="mb-3 text-gray-700">Presensi Anda sudah terjadwal dan akan aktif otomatis saat waktunya tiba.</p>
                        <div class="p-3 border-l-4 border-blue-400 bg-blue-50">
                            <p class="text-sm text-blue-800">
                                <strong>📅 Jadwal:</strong><br>
                                {{ \Carbon\Carbon::parse($presensi->start_time)->format('d M Y, H:i') }} - {{ \Carbon\Carbon::parse($presensi->end_time)->format('H:i') }}
                            </p>
                            <p class="mt-2 text-xs text-blue-600">
                                Dimulai {{ \Carbon\Carbon::parse($presensi->start_time)->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                `,
                icon: 'success',
                confirmButtonText: 'Mengerti',
                confirmButtonColor: '#3b82f6',
                timer: 5000
            });
        }, 800);
    @endif
</script>

@endsection
