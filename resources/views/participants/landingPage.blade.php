<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title>Presensi Peserta Acara</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
        <!-- Navbar -->
        <nav class="fixed top-0 left-0 right-0 z-50 border-b bg-white/90 backdrop-blur-md border-slate-200">
            <div class="container px-4 py-3 mx-auto sm:py-4 max-w-7xl">
                <div class="flex items-center justify-between">
                    <!-- Logo/Brand -->
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div class="flex items-center justify-center w-8 h-8 rounded-lg sm:w-10 sm:h-10 bg-gradient-to-br from-blue-500 to-indigo-600">
                            <svg class="w-4 h-4 text-white sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold sm:text-base text-slate-900">Presensi AI</p>
                            <p class="hidden text-xs sm:block text-slate-500">Face Recognition</p>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <div class="flex items-center gap-1 sm:gap-2">
                        <a href="#home-section"
                           class="px-3 py-2 text-xs font-semibold transition-all rounded-lg sm:px-4 sm:py-2 sm:text-sm text-slate-700 hover:text-blue-600 hover:bg-blue-50">
                            Beranda
                        </a>
                        <a href="#presensi-section"
                           class="px-3 py-2 text-xs font-semibold transition-all rounded-lg sm:px-4 sm:py-2 sm:text-sm text-slate-700 hover:text-blue-600 hover:bg-blue-50">
                            Presensi
                        </a>
                        <a href="#about-section"
                           class="px-3 py-2 text-xs font-semibold transition-all rounded-lg sm:px-4 sm:py-2 sm:text-sm text-slate-700 hover:text-blue-600 hover:bg-blue-50">
                            Tentang
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="relative min-h-screen pt-14 sm:pt-16">

            <!-- Header Section -->
            <div id="home-section"></div>
            <div class="border-b bg-white/80 backdrop-blur-sm border-slate-200/50">
                <div class="container px-4 py-8 mx-auto sm:py-10 md:py-12 max-w-7xl">
                    <div class="text-center">
                        <!-- Badge -->
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 mb-4 sm:mb-6 text-xs sm:text-sm font-semibold tracking-wide text-blue-700 uppercase bg-blue-100 rounded-full">
                            <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-blue-800 rounded-full animate-pulse"></span>
                            <span class="hidden sm:inline">Sistem Presensi dengan AI</span>
                            <span class="sm:hidden">Presensi AI</span>
                        </div>

                        <!-- Heading -->
                        <h1 class="mb-3 text-2xl font-bold tracking-tight sm:mb-4 text-slate-900 sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl">
                            Presensi Peserta Acara
                        </h1>

                        <!-- Subheading -->
                        <p class="max-w-2xl px-4 mx-auto text-sm leading-relaxed sm:text-base md:text-lg text-slate-600">
                            Sistem presensi menggunakan teknologi <span class="font-bold text-blue-600">Face Recognition</span>
                            berbasis <span class="font-bold text-indigo-600">InsightFace</span> untuk verifikasi identitas yang akurat dan aman
                        </p>

                        <!-- Technology Badge -->
                        <div class="flex flex-wrap items-center justify-center gap-2 px-2 mt-4 sm:gap-3 sm:mt-6">
                            <span class="inline-flex items-center gap-1.5 sm:gap-2 px-3 py-1.5 sm:px-4 sm:py-2 text-xs sm:text-sm font-semibold bg-white border border-slate-200 text-slate-700 rounded-xl">
                                <svg class="w-4 h-4 text-blue-600 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                                AI-Powered
                            </span>
                            <span class="inline-flex items-center gap-1.5 sm:gap-2 px-3 py-1.5 sm:px-4 sm:py-2 text-xs sm:text-sm font-semibold bg-white border border-slate-200 text-slate-700 rounded-xl">
                                <svg class="w-4 h-4 text-green-600 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <span class="hidden sm:inline">Aman & Terenkripsi</span>
                                <span class="sm:hidden">Aman</span>
                            </span>
                            <span class="inline-flex items-center gap-1.5 sm:gap-2 px-3 py-1.5 sm:px-4 sm:py-2 text-xs sm:text-sm font-semibold bg-white border border-slate-200 text-slate-700 rounded-xl">
                                <svg class="w-4 h-4 text-purple-600 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                Proses Cepat
                            </span>
                        </div>

                        <!-- CTA Button -->
                        <div class="mt-6 sm:mt-8 md:mt-10">
                            <button
                                onclick="document.getElementById('presensi-section')?.scrollIntoView({ behavior: 'smooth' })"
                                class="inline-flex items-center gap-2 sm:gap-3 px-6 py-3 sm:px-8 md:px-10 sm:py-3.5 md:py-4 text-sm sm:text-base font-semibold text-white transition-all bg-blue-600 rounded-lg hover:bg-blue-700 hover:-translate-y-0.5"
                            >
                                Mulai Presensi
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- InsightFace Info Section -->
            <div class="py-8 sm:py-10 md:py-12 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600">
                <div class="container max-w-6xl px-4 mx-auto">
                    <div class="grid gap-4 sm:gap-5 md:gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        <div class="p-5 sm:p-6 bg-white/10 backdrop-blur-sm rounded-2xl">
                            <div class="flex items-center justify-center w-10 h-10 mb-3 bg-white sm:w-12 sm:h-12 sm:mb-4 rounded-xl">
                                <svg class="w-5 h-5 text-blue-600 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="mb-2 text-base font-bold text-white sm:text-lg">Akurasi Tinggi</h3>
                            <p class="text-xs text-blue-100 sm:text-sm">InsightFace menggunakan deep learning dengan akurasi deteksi wajah hingga 99.8%</p>
                        </div>

                        <div class="p-5 sm:p-6 bg-white/10 backdrop-blur-sm rounded-2xl">
                            <div class="flex items-center justify-center w-10 h-10 mb-3 bg-white sm:w-12 sm:h-12 sm:mb-4 rounded-xl">
                                <svg class="w-5 h-5 text-indigo-600 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <h3 class="mb-2 text-base font-bold text-white sm:text-lg">Proses Real-time</h3>
                            <p class="text-xs text-blue-100 sm:text-sm">Deteksi dan verifikasi wajah dalam hitungan milidetik untuk pengalaman yang seamless</p>
                        </div>

                        <div class="p-5 sm:p-6 bg-white/10 backdrop-blur-sm rounded-2xl sm:col-span-2 lg:col-span-1">
                            <div class="flex items-center justify-center w-10 h-10 mb-3 bg-white sm:w-12 sm:h-12 sm:mb-4 rounded-xl">
                                <svg class="w-5 h-5 text-purple-600 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <h3 class="mb-2 text-base font-bold text-white sm:text-lg">Anti-Spoofing</h3>
                            <p class="text-xs text-blue-100 sm:text-sm">Dilengkapi teknologi liveness detection untuk mencegah pemalsuan dengan foto atau video</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline Steps Section -->
            <div class="relative py-10 sm:py-12 md:py-16 bg-white/50 backdrop-blur-sm">
                <div class="container max-w-5xl px-4 mx-auto">
                    <div class="mb-10 text-center sm:mb-12 md:mb-16">
                        <h2 class="mb-2 text-2xl font-bold sm:mb-3 sm:text-3xl md:text-4xl lg:text-5xl text-slate-900">
                            Cara Presensi
                        </h2>
                        <p class="px-4 text-sm sm:text-base md:text-lg text-slate-600">Ikuti 4 langkah mudah untuk menyelesaikan presensi Anda</p>
                    </div>

                    <div class="relative">
                        <!-- Connection Line - Hidden on mobile -->
                        <div class="absolute left-0 right-0 hidden h-1 lg:block top-16 bg-gradient-to-r from-blue-200 via-indigo-200 to-purple-200" style="width: calc(100% - 14rem); margin: 0 7rem;"></div>

                        <div class="grid grid-cols-2 gap-6 sm:gap-8 md:gap-10 lg:grid-cols-4">
                            <!-- Step 1 -->
                            <div class="relative flex flex-col items-center group">
                                <div class="relative z-10 flex items-center justify-center w-20 h-20 transition-all duration-300 rounded-full sm:w-24 sm:h-24 md:w-28 md:h-28 lg:w-32 lg:h-32 bg-gradient-to-br from-blue-500 to-indigo-600 group-hover:scale-110">
                                    <div class="relative text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 mx-auto mb-1 text-white sm:w-10 sm:h-10 md:w-12 md:h-12">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                        </svg>
                                        <span class="text-[10px] sm:text-xs font-bold text-white">STEP 1</span>
                                    </div>
                                </div>
                                <div class="px-2 mt-3 text-center sm:mt-4 md:mt-6">
                                    <h3 class="mb-1 text-xs font-bold sm:mb-2 sm:text-sm md:text-base text-slate-900">Cari Nama</h3>
                                    <p class="text-[10px] sm:text-xs md:text-sm leading-relaxed text-slate-600">Cari dan pilih nama Anda dari daftar peserta</p>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div class="relative flex flex-col items-center group">
                                <div class="relative z-10 flex items-center justify-center w-20 h-20 transition-all duration-300 bg-white border-4 rounded-full sm:w-24 sm:h-24 md:w-28 md:h-28 lg:w-32 lg:h-32 border-slate-300 group-hover:scale-110 group-hover:border-blue-400">
                                    <div class="text-center">
                                        <svg class="w-8 h-8 mx-auto mb-1 transition-colors sm:w-10 sm:h-10 md:w-12 md:h-12 text-slate-600 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-[10px] sm:text-xs font-bold transition-colors text-slate-600 group-hover:text-blue-600">STEP 2</span>
                                    </div>
                                </div>
                                <div class="px-2 mt-3 text-center sm:mt-4 md:mt-6">
                                    <h3 class="mb-1 text-xs font-bold sm:mb-2 sm:text-sm md:text-base text-slate-900">Cek Status</h3>
                                    <p class="text-[10px] sm:text-xs md:text-sm leading-relaxed text-slate-600">Sistem akan memeriksa data wajah Anda</p>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="relative flex flex-col items-center group">
                                <div class="relative z-10 flex items-center justify-center w-20 h-20 transition-all duration-300 bg-white border-4 rounded-full sm:w-24 sm:h-24 md:w-28 md:h-28 lg:w-32 lg:h-32 border-slate-300 group-hover:scale-110 group-hover:border-indigo-400">
                                    <div class="text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 mx-auto mb-1 transition-colors sm:w-10 sm:h-10 md:w-12 md:h-12 text-slate-600 group-hover:text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M3 7V5a2 2 0 0 1 2-2h2"></path>
                                            <path d="M17 3h2a2 2 0 0 1 2 2v2"></path>
                                            <path d="M21 17v2a2 2 0 0 1-2 2h-2"></path>
                                            <path d="M7 21H5a2 2 0 0 1-2-2v-2"></path>
                                            <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                                            <path d="M9 9h.01"></path>
                                            <path d="M15 9h.01"></path>
                                        </svg>
                                        <span class="text-[10px] sm:text-xs font-bold transition-colors text-slate-600 group-hover:text-indigo-600">STEP 3</span>
                                    </div>
                                </div>
                                <div class="px-2 mt-3 text-center sm:mt-4 md:mt-6">
                                    <h3 class="mb-1 text-xs font-bold sm:mb-2 sm:text-sm md:text-base text-slate-900">Verifikasi Wajah</h3>
                                    <p class="text-[10px] sm:text-xs md:text-sm leading-relaxed text-slate-600">Face Recognition dengan InsightFace</p>
                                </div>
                            </div>

                            <!-- Step 4 -->
                            <div class="relative flex flex-col items-center group">
                                <div class="relative z-10 flex items-center justify-center w-20 h-20 transition-all duration-300 bg-white border-4 rounded-full sm:w-24 sm:h-24 md:w-28 md:h-28 lg:w-32 lg:h-32 border-slate-300 group-hover:scale-110 group-hover:border-green-400">
                                    <div class="text-center">
                                        <svg class="w-8 h-8 mx-auto mb-1 transition-colors sm:w-10 sm:h-10 md:w-12 md:h-12 text-slate-600 group-hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="text-[10px] sm:text-xs font-bold transition-colors text-slate-600 group-hover:text-green-600">STEP 4</span>
                                    </div>
                                </div>
                                <div class="px-2 mt-3 text-center sm:mt-4 md:mt-6">
                                    <h3 class="mb-1 text-xs font-bold sm:mb-2 sm:text-sm md:text-base text-slate-900">Selesai</h3>
                                    <p class="text-[10px] sm:text-xs md:text-sm leading-relaxed text-slate-600">Presensi berhasil tercatat otomatis</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Presensi Section -->
            <div id="presensi-section" class="relative py-12 sm:py-16 md:py-20 lg:py-24">
                <div class="container max-w-5xl px-4 mx-auto">

                    <!-- Header -->
                    <div class="mb-8 text-center sm:mb-10 md:mb-12">
                        <h2 class="mb-2 text-2xl font-bold sm:mb-3 sm:text-3xl md:text-4xl lg:text-5xl text-slate-900">
                            Daftar Peserta
                        </h2>
                        <p class="px-4 text-sm sm:text-base md:text-lg text-slate-600">
                            Cari nama Anda dan lakukan presensi dengan teknologi Face Recognition
                        </p>
                    </div>

                    <!-- Card -->
                    <div class="relative p-4 overflow-hidden bg-white border sm:p-6 md:p-8 lg:p-10 rounded-2xl md:rounded-3xl border-slate-200">
                        <!-- Decorative gradient -->
                        <div class="absolute top-0 left-0 right-0 h-1.5 sm:h-2 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500"></div>

                        <!-- Search -->
                        <div class="relative mb-6 sm:mb-8">
                            <div class="relative">
                                <svg class="absolute w-5 h-5 -translate-y-1/2 sm:w-6 sm:h-6 text-slate-400 left-3 sm:left-4 md:left-5 top-1/2"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>

                                <input
                                    type="text"
                                    id="searchInput"
                                    placeholder="Ketik nama Anda untuk mencari..."
                                    class="w-full py-3 pl-10 pr-10 text-sm font-medium transition-all bg-white border border-slate-300 sm:py-4 md:py-5 sm:text-base sm:pl-12 md:pl-14 sm:pr-12 md:pr-14 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder:text-slate-400"
                                    onkeyup="filterParticipants()"
                                />

                                <button
                                    id="clearBtn"
                                    onclick="clearSearch()"
                                    class="absolute hidden transition-colors -translate-y-1/2 text-slate-400 right-3 sm:right-4 md:right-5 top-1/2 hover:text-slate-600"
                                >
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- List Peserta -->
                        <div id="participantList" class="space-y-2 sm:space-y-3 overflow-y-auto max-h-[360px] sm:max-h-[420px] md:max-h-[480px] pr-1 sm:pr-2">
                            @foreach ($participants as $participant)
                                <div class="participant-item" data-name="{{ strtolower($participant->name) }}">
                                    <button
                                        type="button"
                                        onclick="checkParticipant(
                                            {{ $participant->id }},
                                            '{{ $participant->name }}',
                                            {{ $participant->face_images ? 'true' : 'false' }},
                                            {{ $participant->attendances->isNotEmpty() ? 'true' : 'false' }}
                                        )"
                                        class="w-full text-left group"
                                    >
                                        <div class="relative flex items-center gap-3 p-3 overflow-hidden transition-all duration-300 border sm:gap-4 md:gap-5 sm:p-4 md:p-5 border-slate-200 rounded-xl md:rounded-2xl hover:border-blue-400 bg-gradient-to-r from-transparent to-transparent hover:from-blue-50/50 hover:to-indigo-50/50">
                                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 transition-all duration-300 rounded-lg sm:w-14 sm:h-14 md:w-16 md:h-16 md:rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 group-hover:from-blue-100 group-hover:to-indigo-100 group-hover:scale-110">
                                                <svg class="w-6 h-6 transition-colors sm:w-7 sm:h-7 md:w-8 md:h-8 text-slate-600 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            </div>

                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-bold truncate transition-colors sm:text-base text-slate-900 group-hover:text-blue-700">
                                                    {{ $participant->name }}
                                                </p>
                                                @if ($activeSetting)
                                                    @if ($participant->attendances->isNotEmpty())
                                                        <div class="flex items-center gap-1.5 sm:gap-2 mt-1">
                                                            <span class="relative flex w-1.5 h-1.5 sm:w-2 sm:h-2">
                                                                <span class="absolute inline-flex w-full h-full bg-green-400 rounded-full opacity-75 animate-ping"></span>
                                                                <span class="relative inline-flex w-1.5 h-1.5 sm:w-2 sm:h-2 bg-green-500 rounded-full"></span>
                                                            </span>
                                                            <span class="text-xs font-bold text-green-600 sm:text-sm">Sudah Presensi</span>
                                                        </div>
                                                    @else
                                                        <div class="flex items-center gap-1.5 sm:gap-2 mt-1">
                                                            <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-slate-400"></span>
                                                            <span class="text-xs font-medium sm:text-sm text-slate-500">Belum Presensi</span>
                                                        </div>
                                                    @endif
                                                @else
                                                    <span class="text-xs sm:text-sm text-slate-400">Presensi belum dibuka</span>
                                                @endif
                                            </div>

                                            <svg class="flex-shrink-0 w-5 h-5 transition-all sm:w-6 sm:h-6 text-slate-400 group-hover:text-blue-500 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </div>
                                    </button>
                                </div>
                            @endforeach
                        </div>

                        <!-- Empty State -->
                        <div id="emptyState" class="hidden py-12 text-center sm:py-16">
                            <div class="flex items-center justify-center w-20 h-20 mx-auto mb-4 rounded-full sm:w-24 sm:h-24 sm:mb-6 bg-gradient-to-br from-slate-100 to-slate-200">
                                <svg class="w-10 h-10 sm:w-12 sm:h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <p class="mb-2 text-lg font-bold sm:text-xl text-slate-900">
                                Peserta tidak ditemukan
                            </p>
                            <p class="px-4 text-xs sm:text-sm text-slate-500">
                                Coba periksa kembali nama yang Anda masukkan
                            </p>
                        </div>

                        <!-- Footer -->
                        <div class="flex flex-col items-center justify-between gap-3 pt-4 mt-6 border-t sm:flex-row sm:gap-0 sm:pt-6 sm:mt-8 border-slate-100">
                            <p class="text-xs font-medium text-center sm:text-sm text-slate-600 sm:text-left">
                                Menampilkan
                                <span id="resultCount" class="font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">
                                    {{ count($participants) }}
                                </span>
                                dari {{ count($participants) }} peserta
                            </p>

                            <span class="inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-2 sm:py-2.5 text-[10px] sm:text-xs font-bold tracking-wide text-white uppercase bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg">
                                <span class="relative flex w-1.5 h-1.5 sm:w-2 sm:h-2">
                                    <span class="absolute inline-flex w-full h-full bg-white rounded-full opacity-75 animate-ping"></span>
                                    <span class="relative inline-flex w-1.5 h-1.5 sm:w-2 sm:h-2 bg-white rounded-full"></span>
                                </span>
                                Sistem Aktif
                            </span>
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="grid gap-3 mt-6 sm:gap-4 sm:mt-8 md:grid-cols-2">
                        <div class="flex items-center gap-2 px-4 py-3 bg-white border border-slate-200 sm:gap-3 sm:px-5 md:px-6 sm:py-4 rounded-xl sm:rounded-2xl">
                            <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-gradient-to-br from-blue-100 to-indigo-100">
                                <svg class="w-4 h-4 text-blue-600 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold sm:text-sm text-slate-700">Data wajah tersimpan aman dengan enkripsi</span>
                        </div>

                        <div class="flex items-center gap-2 px-4 py-3 bg-white border border-slate-200 sm:gap-3 sm:px-5 md:px-6 sm:py-4 rounded-xl sm:rounded-2xl">
                            <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-gradient-to-br from-purple-100 to-pink-100">
                                <svg class="w-4 h-4 text-purple-600 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold sm:text-sm text-slate-700">Powered by InsightFace AI Model</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- About Section -->
            <div id="about-section" class="py-12 sm:py-16 md:py-20 bg-white/70 backdrop-blur-sm">
                <div class="container max-w-4xl px-4 mx-auto">
                    <div class="mb-8 text-center sm:mb-10">
                        <h2 class="mb-2 text-2xl font-bold sm:mb-3 sm:text-3xl md:text-4xl text-slate-900">
                            Tentang Aplikasi
                        </h2>
                        <p class="text-sm sm:text-base text-slate-600">Sistem Presensi Berbasis Face Recognition</p>
                    </div>

                    <div class="p-6 bg-white border sm:p-8 md:p-10 border-slate-200 rounded-2xl">
                        <!-- App Info -->
                        <div class="pb-6 mb-6 border-b border-slate-200">
                            <div class="flex items-start gap-3 mb-4">
                                <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 rounded-lg sm:w-14 sm:h-14 bg-gradient-to-br from-blue-500 to-indigo-600">
                                    <svg class="w-6 h-6 text-white sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="mb-1 text-lg font-bold sm:text-xl text-slate-900">Sistem Presensi AI</h3>
                                    <p class="text-sm font-medium sm:text-base text-slate-600">Versi 1.0.0</p>
                                </div>
                            </div>
                            <p class="text-sm leading-relaxed sm:text-base text-slate-700">
                                Aplikasi presensi modern menggunakan teknologi Face Recognition berbasis InsightFace untuk verifikasi identitas peserta acara secara akurat, cepat, dan aman.
                            </p>
                        </div>

                        <!-- Developers -->
                        <div class="mb-6">
                            <h4 class="mb-3 text-base font-bold sm:text-lg text-slate-900">Tim Pengembang</h4>
                            <div class="space-y-2">
                                <div class="flex items-center gap-2 text-sm sm:text-base text-slate-700">
                                    <svg class="flex-shrink-0 w-4 h-4 text-blue-600 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span>Slamet Riyadi</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm sm:text-base text-slate-700">
                                    <svg class="flex-shrink-0 w-4 h-4 text-blue-600 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span>Cahya Damarjati</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm sm:text-base text-slate-700">
                                    <svg class="flex-shrink-0 w-4 h-4 text-blue-600 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span>[Nama Anda]</span>
                                </div>
                            </div>
                        </div>

                        <!-- Institution -->
                        <div class="p-4 border-l-4 border-blue-600 sm:p-5 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-r-xl">
                            <p class="text-sm leading-relaxed sm:text-base text-slate-700">
                                <span class="font-bold text-blue-900">Program Studi Teknologi Informasi</span> bekerja sama dengan
                                <span class="font-bold text-indigo-900">Artificial Intelligence and Robotics Research Group</span>
                                <br/>
                                <span class="font-bold text-slate-900">Universitas Muhammadiyah Yogyakarta</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="py-6 bg-slate-900 sm:py-8">
                <div class="container max-w-6xl px-4 mx-auto">
                    <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                        <!-- Logo/Brand -->
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div class="flex items-center justify-center w-10 h-10 rounded-lg sm:w-12 sm:h-12 bg-gradient-to-br from-blue-500 to-indigo-600">
                                <svg class="w-5 h-5 text-white sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-white sm:text-base">Sistem Presensi AI</p>
                                <p class="text-xs text-slate-400">Face Recognition System</p>
                            </div>
                        </div>

                        <!-- Navigation -->
                        <div class="flex items-center gap-4 text-sm sm:gap-6 sm:text-base">
                            <a href="#presensi-section" class="transition-colors text-slate-300 hover:text-white">
                                Presensi
                            </a>
                            <a href="#about-section" class="transition-colors text-slate-300 hover:text-white">
                                Tentang
                            </a>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="my-6 border-t border-slate-700"></div>

                    <!-- Copyright -->
                    <div class="text-center">
                        <p class="mb-2 text-sm text-slate-400 sm:text-base">
                            © 2024 <span class="font-semibold text-white">Universitas Muhammadiyah Yogyakarta</span>
                        </p>
                        <p class="text-xs text-slate-500 sm:text-sm">
                            Program Studi Teknologi Informasi - AI & Robotics Research Group
                        </p>
                    </div>
                </div>
            </footer>

            <!-- Modal: Training Wajah -->
            <div id="confirmTrainingModal" class="fixed inset-0 z-50 items-center justify-center hidden p-4 bg-black/60 backdrop-blur-sm">
                <div class="w-full max-w-lg p-6 sm:p-8 bg-white rounded-2xl max-h-[90vh] overflow-y-auto">
                    <div class="mb-6 text-center sm:mb-8">
                        <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full sm:w-20 sm:h-20 sm:mb-5 bg-amber-100">
                            <svg class="w-8 h-8 sm:w-10 sm:h-10 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-bold sm:text-2xl text-slate-900">
                            Data Wajah Belum Terdaftar
                        </h3>
                        <p class="px-2 mb-3 text-sm leading-relaxed sm:mb-4 sm:text-base text-slate-600">
                            Anda perlu melakukan pendaftaran wajah terlebih dahulu sebelum dapat melakukan presensi menggunakan Face Recognition.
                        </p>
                        <div class="p-3 border border-blue-200 sm:p-4 bg-blue-50 rounded-xl">
                            <p class="text-xs font-semibold text-blue-800 sm:text-sm">
                                <svg class="inline-block w-4 h-4 mr-1 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Sistem menggunakan model InsightFace untuk mengenali wajah Anda dengan akurasi tinggi
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 sm:gap-3">
                        <button id="confirmTrainingBtn"
                            class="w-full px-5 py-3 text-sm font-bold text-white transition-all bg-blue-600 sm:px-6 sm:py-4 sm:text-base rounded-xl hover:bg-blue-700">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Daftarkan Wajah Sekarang
                            </span>
                        </button>

                        <button onclick="closeTrainingModal()"
                            class="w-full px-5 py-3 text-sm font-semibold transition-all border sm:px-6 sm:py-4 sm:text-base text-slate-700 bg-slate-50 border-slate-300 rounded-xl hover:bg-slate-100">
                            Batal
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <script>
            let selectedParticipantId = null;
            let selectedParticipantName = null;
            let selectedParticipantHasFace = false;

            window.presensiAktif = {{ $activeSetting ? 'true' : 'false' }};

            function checkParticipant(id, name, hasFace, alreadyAttended) {
                if (!window.presensiAktif) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Presensi Belum Dibuka',
                        text: 'Silakan tunggu hingga presensi dibuka oleh panitia.',
                        confirmButtonColor: '#2563eb',
                        confirmButtonText: 'Mengerti'
                    });
                    return;
                }

                if (alreadyAttended) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sudah Presensi',
                        text: `${name} sudah melakukan presensi.`,
                        confirmButtonColor: '#10b981',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                selectedParticipantId = id;
                selectedParticipantName = name;
                selectedParticipantHasFace = hasFace;

                if (!hasFace) {
                    openTrainingModal();
                } else {
                    window.location.href = `/peserta/presensi/${id}`;
                }
            }

            function openTrainingModal() {
                const modal = document.getElementById('confirmTrainingModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }

            function closeTrainingModal() {
                const modal = document.getElementById('confirmTrainingModal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = 'auto';
            }

            document.getElementById('confirmTrainingBtn')?.addEventListener('click', function () {
                window.location.href = `/training-page/${selectedParticipantId}`;
            });

            function filterParticipants() {
                const input = document.getElementById('searchInput');
                const filter = input.value.toLowerCase();
                const items = document.querySelectorAll('.participant-item');
                const empty = document.getElementById('emptyState');
                const clearBtn = document.getElementById('clearBtn');
                let visible = 0;

                items.forEach(item => {
                    const name = item.dataset.name;
                    if (name.includes(filter)) {
                        item.classList.remove('hidden');
                        visible++;
                    } else {
                        item.classList.add('hidden');
                    }
                });

                document.getElementById('resultCount').innerText = visible;
                empty.classList.toggle('hidden', visible !== 0);
                clearBtn.classList.toggle('hidden', filter.length === 0);
            }

            function clearSearch() {
                document.getElementById('searchInput').value = '';
                filterParticipants();
            }

            document.getElementById('confirmTrainingModal')?.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeTrainingModal();
                }
            });


            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });
        </script>
    </body>
</html>
