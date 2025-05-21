<div class="flex flex-col w-64 bg-gray-800 text-gray-100">
    <div class="flex items-center justify-center h-20 border-b border-gray-700">
        <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold text-white">Admin GajiKu</a>
    </div>
    <nav class="flex-1 px-2 py-4 space-y-2 overflow-y-auto">
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Dashboard
        </a>
        <a href="{{ route('admin.karyawan.index') }}"
           class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700 {{ request()->routeIs('admin.karyawan.*') ? 'bg-gray-700' : '' }}">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Kelola Karyawan
        </a>
        <a href="{{ route('admin.absensi.rekap') }}"
           class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700 {{ request()->routeIs('admin.absensi.rekap') ? 'bg-gray-700' : '' }}">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Rekap Absensi
        </a>
        <a href="{{ route('admin.gaji.index') }}"
           class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700 {{ request()->routeIs('admin.gaji.*') ? 'bg-gray-700' : '' }}">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            Penggajian
        </a>
    </nav>
</div>