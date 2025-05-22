<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/fontawesome.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Tambahkan script/style lain jika perlu --}}
    
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="flex h-screen bg-gray-200">
        <!-- Sidebar -->
        @auth
            @if (Auth::user()->isAdmin())
                @include('partials._sidebar_admin')
            @elseif (Auth::user()->isKaryawan())
                @include('partials._sidebar_karyawan')
            @endif
        @endauth

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            @auth
                @include('partials._header')
            @endauth

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <div class="container mx-auto">
                    @include('partials._alerts')
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>