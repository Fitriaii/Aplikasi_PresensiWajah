<header class="sticky top-0 z-50 bg-white border-b border-gray-200 shadow-sm">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <!-- Logo & Judul -->
            <div class="flex items-center space-x-3">
                <div>
                    <h1 class="text-lg font-bold tracking-tight text-gray-900 sm:text-xl font-heading">
                        Universitas Muhammadiyah Yogyakarta
                    </h1>
                    <p class="hidden text-sm font-medium text-gray-600 sm:block">
                        Sistem Presensi Digital
                    </p>
                </div>
            </div>

            <!-- Info Waktu -->
            <div class="flex items-center gap-3">

                <!-- Tanggal -->
                <div class="hidden md:flex items-center gap-2 px-3 py-1.5 rounded-lg bg-purple-50 text-purple-700">
                    <calendar-icon class="w-5 h-5" />
                    <span class="text-sm font-medium leading-none">
                        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                    </span>
                </div>

                <!-- Jam -->
                <div class="flex items-center gap-4 px-6 py-1.5">
                    <clock-icon class="w-5 h-5" />
                    <span class="text-sm font-semibold leading-none" x-text="time">
                        {{ \Carbon\Carbon::now()->format('H:i:s') }}
                    </span>
                </div>

            </div>
        </div>
    </div>
</header>
