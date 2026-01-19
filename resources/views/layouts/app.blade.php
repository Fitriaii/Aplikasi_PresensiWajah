<!DOCTYPE html>
<html x-data="data()" lang="en" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PresenSee') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.1/dist/cdn.min.js"></script>

        <!-- DataTables CSS -->
        <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">

        <!-- jQuery (Required for DataTables.js) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script type="module" src="https://unpkg.com/cally"></script>
    </head>
    <body class="h-screen overflow-hidden">
        @include('sweetalert::alert')

        <div class="flex h-screen bg-gray-100">

            {{-- SIDEBAR (ADMIN ONLY) --}}
            @if (Auth::check())
                @include('layouts.sidebar-admin')
            @endif

            <div
                x-show="isSideMenuOpen"
                x-cloak
                @click="closeSideMenu"
                class="fixed inset-0 z-10 bg-black bg-opacity-50 md:hidden"
                x-transition:enter="transition ease-in-out duration-150"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in-out duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            ></div>

            @if (Auth::check())
                @include('layouts.mobile-sidebar')
            @endif


            {{-- MAIN CONTENT --}}
            <div class="flex flex-col flex-1 min-w-0 min-h-screen">

                @if (Auth::check())
                    <div class="flex-shrink-0 bg-white border-b border-gray-200">
                        @include('layouts.navbar-admin')
                    </div>
                @endif

                {{-- CONTENT --}}
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                    @yield('content')
                </main>

                {{-- FOOTER (BOLEH UNTUK SEMUA) --}}
                <div class="w-full py-4 text-center bg-white border-t border-gray-200">
                    <p class="text-xs text-gray-500">
                        © {{ date('Y') }}
                        <span class="font-semibold text-purple-600">PresenSee</span>.
                        Sistem Presensi Acara.
                    </p>
                </div>

            </div>
        </div>
    </body>

</html>
