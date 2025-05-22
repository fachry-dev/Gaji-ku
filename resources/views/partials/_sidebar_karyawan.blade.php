<div class="flex flex-col w-64 bg-teal-700 text-gray-100">
    <div class="flex items-center justify-center h-20 border-b border-teal-600">
        <a href="{{ route('karyawan.dashboard') }}" class="text-2xl font-bold text-white">Gaji-ku</a>
    </div>
    
    <nav class="flex-1 px-2 py-4 space-y-2 overflow-y-auto">
        <a href="{{ route('karyawan.dashboard') }}"
           class="flex items-center px-4 py-2 rounded-md hover:bg-teal-600 {{ request()->routeIs('karyawan.dashboard') ? 'bg-teal-600' : '' }}">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Dashboard
        </a>
        <a href="{{ route('karyawan.absensi.form') }}"
           class="flex items-center px-4 py-2 rounded-md hover:bg-teal-600 {{ request()->routeIs('karyawan.absensi.form') ? 'bg-teal-600' : '' }}">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Presensi
        </a>
        <a href="{{ route('karyawan.absensi.riwayat') }}"
           class="flex items-center px-4 py-2 rounded-md hover:bg-teal-600 {{ request()->routeIs('karyawan.absensi.riwayat') ? 'bg-teal-600' : '' }}">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            Riwayat Absensi
        </a>
    </nav>
</div>