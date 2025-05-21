<header class="flex items-center justify-between px-6 py-4 bg-white border-b-2 border-gray-200">
    <div class="flex items-center">
        {{-- Tombol untuk toggle sidebar di mobile (jika diperlukan) --}}
        {{-- <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button> --}}
        <h2 class="text-xl font-semibold text-gray-700">@yield('title', 'Dashboard')</h2>
    </div>

    <div class="flex items-center">
        <span class="text-gray-700 mr-4">Halo, {{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-blue-500 hover:text-blue-700 focus:outline-none">
                Logout
            </button>
        </form>
    </div>
</header>