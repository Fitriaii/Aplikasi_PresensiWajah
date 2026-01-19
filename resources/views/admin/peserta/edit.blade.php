@extends('layouts.app')

@section('content')

<div class="container p-6 mx-auto">
    {{-- Header Section --}}
    <div class="z-50 p-4 mb-4 bg-white rounded-sm shadow font-heading">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-purple-800 font-heading">Edit Data Peserta</h2>
            <div class="flex space-x-1 font-sans text-xs text-gray-500">
                <a href="{{ route('dashboard') }}" class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">Beranda</a>
                <span>/</span>
                <a href="{{ route('peserta.index') }}" class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">Peserta</a>
                <span>/</span>
                <span class="text-gray-400">Edit Peserta</span>
            </div>
        </div>
    </div>

    {{-- Input Form --}}
    <div class="w-full p-6 mb-8 bg-white border border-gray-200 rounded-sm shadow-sm drop-shadow">

        <form id="Form" action="{{ route('peserta.update', $participants) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <h3 class="pb-2 text-lg font-semibold text-purple-800 border-b border-gray-200 font-heading">Informasi Personal</h3>
                <!-- Nama -->
                <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3">
                    <div class="lg:text-right">
                        <label for="name" class="block mb-1 text-sm font-semibold text-gray-700 font-heading">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="lg:col-span-2">
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', isset($participants) ? $participants->name : '') }}"
                            required
                            placeholder="Masukkan Nama Lengkap"
                            class="w-full px-4 py-3 text-sm transition-colors duration-200 border border-gray-300 rounded-lg outline-none hover:border-purple-400 dark:bg-white dark:text-gray-900 dark:border-gray-300 focus:ring-purple-500/20 focus:border-purple-500"
                        />
                        @error('name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>


                <!-- JK -->
                <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3">
                    <div class="lg:text-right">
                        <label for="jenis_kelamin" class="block mb-1 text-sm font-semibold text-gray-700 font-heading">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="lg:col-span-2">
                        <select
                            name="gender"
                            id="gender"
                            required
                            class="w-full px-4 py-3 text-sm transition-colors duration-200 border border-gray-300 rounded-lg outline-none hover:border-purple-400 dark:bg-white dark:text-gray-900 dark:border-gray-300 focus:ring-purple-500/20 focus:border-purple-500"
                        >
                            <option value="" disabled {{ old('gender', $participants->gender ?? '') == '' ? 'selected' : '' }}>Pilih Jenis Kelamin</option>
                            <option value="L" {{ old('gender', $participants->gender ?? '') == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                            <option value="P" {{ old('gender', $participants->gender ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex flex-col justify-end gap-4 pt-8 border-t border-gray-200 sm:flex-row">
                <a href="{{ route('peserta.index') }}" type="button"
                    class="px-6 py-3 text-sm font-medium text-gray-700 transition-colors duration-200 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-3 text-sm font-semibold text-white transition-colors duration-200 bg-purple-600 rounded-lg shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-200 hover:shadow-md">
                    <span class="flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        Perbarui Data Peserta
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
