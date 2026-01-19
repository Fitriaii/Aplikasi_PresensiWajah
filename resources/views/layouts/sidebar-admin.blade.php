<aside x-data="data()" class="z-50 flex-shrink-0 hidden overflow-y-auto bg-white border-r border-gray-200 shadow-lg w-72 md:block">
    <div class="py-8 text-gray-700">
        <!-- Logo Section -->
        <div class="flex justify-center px-6 mb-8">
            <a class="text-2xl font-bold tracking-tight text-purple-600 transition-colors duration-200 hover:text-purple-700" href="#">
                PresenSee
            </a>
        </div>

        <!-- Navigation Menu -->
        <nav class="space-y-1" x-data x-init="
            const path = window.location.pathname;
            if (path.includes('dashboard')) activeMenu = 'dashboard';
            else if (path.includes('peserta')) activeMenu = 'peserta';
            else if (path.includes('presensi')) activeMenu = 'presensi';
        ">

            <!-- Dashboard -->
            <div class="px-3">
                <a href="{{ route('dashboard') }}" @click="activeMenu = 'dashboard'"
                    class="flex items-center px-4 py-3 text-sm font-medium transition-all duration-200 ease-in-out rounded-lg group"
                    :class="activeMenu === 'dashboard'
                        ? 'bg-purple-50 text-purple-700 border-r-3 border-purple-600 shadow-sm'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'">
                    <svg class="flex-shrink-0 w-5 h-5 mr-3 transition-colors duration-200"
                        :class="activeMenu === 'dashboard' ? 'text-purple-500' : 'text-gray-400 group-hover:text-gray-500'"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="7" height="9" x="3" y="3" rx="1"></rect>
                        <rect width="7" height="5" x="14" y="3" rx="1"></rect>
                        <rect width="7" height="9" x="14" y="12" rx="1"></rect>
                        <rect width="7" height="5" x="3" y="16" rx="1"></rect>
                    </svg>
                    Dashboard
                </a>
            </div>

            <!-- Daftar Siswa -->
            <div class="px-3">
                <a href="{{ route('peserta.index') }}" @click="activeMenu = 'peserta'"
                    class="flex items-center px-4 py-3 text-sm font-medium transition-all duration-200 ease-in-out rounded-lg group"
                    :class="activeMenu === 'peserta'
                        ? 'bg-purple-50 text-purple-700 border-r-3 border-purple-600 shadow-sm'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'">
                    <svg class="flex-shrink-0 w-5 h-5 mr-3 transition-colors duration-200"
                        :class="activeMenu === 'peserta' ? 'text-purple-500' : 'text-gray-400 group-hover:text-gray-500'"
                        fill="none" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"></path>
                    </svg>
                    Daftar Peserta
                </a>
            </div>

            <!-- Presensi -->
            <div class="px-3">
                <a href="{{ route('presensi.setting.page') }}" @click="activeMenu = 'presensi'"
                    class="flex items-center px-4 py-3 text-sm font-medium transition-all duration-200 ease-in-out rounded-lg group"
                    :class="activeMenu === 'presensi'
                        ? 'bg-purple-50 text-purple-700 border-r-3 border-purple-600 shadow-sm'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'">
                    <svg class="flex-shrink-0 w-5 h-5 mr-3 transition-colors duration-200"
                                :class="activeMenu === 'presensi' ? 'text-purple-500' : 'text-gray-400 group-hover:text-gray-500'"
                                fill="none" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                    </svg>
                    Presensi
                </a>
            </div>
        </nav>
    </div>
</aside>
