@extends('layouts.app')

@section('title', 'Dashboard Karyawan')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Salam Pembuka -->
    <div class="mb-8 p-6 bg-teal-600 text-white rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold">Halo, {{ $karyawan->nama_lengkap }}!</h1>
        <p class="mt-1 text-teal-100">Selamat datang di dashboard karyawan Anda.</p>
    </div>

    <!-- Informasi Karyawan & Status Presensi Hari Ini -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Informasi Karyawan -->
        <div class="bg-white shadow-lg rounded-xl p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Informasi Anda</h2>
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-500 font-medium">NIP</p>
                    <p class="text-lg text-gray-800">{{ $karyawan->nip }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Jabatan</p>
                    <p class="text-lg text-gray-800">{{ $karyawan->jabatan }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Tanggal Bergabung</p>
                    <p class="text-lg text-gray-800">{{ \Carbon\Carbon::parse($karyawan->tanggal_masuk)->translatedFormat('d F Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Status Presensi Hari Ini -->
        <div class="bg-white shadow-lg rounded-xl p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-1">Presensi Hari Ini</h2>
            <p class="text-sm text-gray-500 mb-4">{{ \Carbon\Carbon::today()->translatedFormat('l, d F Y') }}</p>

            @if ($absensiHariIni && $absensiHariIni->jam_masuk)
                <div class="mb-3 p-3 bg-green-100 text-green-700 rounded-md text-sm">
                    <span class="font-semibold">Masuk:</span> {{ \Carbon\Carbon::parse($absensiHariIni->jam_masuk)->format('H:i:s') }}
                </div>
                @if ($absensiHariIni->jam_pulang)
                    <div class="p-3 bg-blue-100 text-blue-700 rounded-md text-sm">
                        <span class="font-semibold">Pulang:</span> {{ \Carbon\Carbon::parse($absensiHariIni->jam_pulang)->format('H:i:s') }}
                    </div>
                @else
                    <div class="p-3 bg-yellow-100 text-yellow-700 rounded-md text-sm">
                        Anda sudah presensi masuk, jangan lupa presensi pulang.
                    </div>
                @endif
            @else
                <div class="p-3 bg-red-100 text-red-700 rounded-md text-sm">
                    Anda belum melakukan presensi masuk hari ini.
                </div>
            @endif
            <div class="mt-5 text-center">
                <a href="{{ route('karyawan.absensi.form') }}"
                   class="w-full sm:w-auto inline-block px-6 py-3 bg-teal-500 hover:bg-teal-600 text-[#1d1d1d1d] transition-all ease-in-out hover:text-white font-semibold rounded-lg shadow-md duration-1000">
                    Lakukan Presensi Sekarang
                </a>
            </div>
        </div>
    </div>

    <!-- Ringkasan Absensi & Aksi Cepat Lainnya -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Ringkasan Absensi Bulan Ini -->
        <div class="bg-white shadow-lg rounded-xl p-6 flex flex-col justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-700 mb-1">Ringkasan Absensi</h2>
                <p class="text-sm text-gray-500 mb-4">Bulan {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
                <div class="flex items-center justify-around text-center mb-4">
                    <div>
                        <p class="text-3xl font-bold text-green-600">{{ $jumlahHadirBulanIni }}</p>
                        <p class="text-sm text-gray-500">Hari Hadir</p>
                    </div>
                    <div>
                        {{-- Placeholder untuk Alpha/Izin/Sakit jika ada datanya --}}
                        <p class="text-3xl font-bold text-red-500">-</p>
                        <p class="text-sm text-gray-500">Hari Alpha</p>
                    </div>
                </div>
            </div>
            <div class="mt-auto text-center">
                 <a href="{{ route('karyawan.absensi.riwayat') }}"
                   class="w-full sm:w-auto inline-block px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg shadow-sm transition duration-300">
                    Lihat Riwayat Absensi Lengkap
                </a>
            </div>
        </div>

        <!-- Aksi Cepat Lainnya (Contoh: Slip Gaji) -->
        <div class="bg-white shadow-lg rounded-xl p-6 flex flex-col items-center justify-center text-center">
            <div class="p-4 bg-purple-100 rounded-full mb-4">
                <svg class="w-12 h-12 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-700 mb-2">Slip Gaji</h2>
            <p class="text-gray-500 text-sm mb-4">Lihat rincian gaji Anda per periode.</p>
            <button disabled
                    class="w-full sm:w-auto px-6 py-3 bg-purple-500 hover:bg-purple-600 text-white font-semibold rounded-lg shadow-md transition duration-300 opacity-50 cursor-not-allowed">
                Lihat Slip Gaji (Segera Hadir)
            </button>
            {{-- Jika sudah ada fitur slip gaji untuk karyawan:
            <a href="{{ route('karyawan.gaji.slip_terakhir') }}" -- Ganti dengan route yang sesuai
               class="w-full sm:w-auto px-6 py-3 bg-purple-500 hover:bg-purple-600 text-white font-semibold rounded-lg shadow-md transition duration-300">
                Lihat Slip Gaji Terakhir
            </a>
            --}}
        </div>
    </div>

    {{-- Pengumuman atau Informasi Penting dari Admin (Jika Ada) --}}
    
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md shadow-sm">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 3.001-1.742 3.001H4.42c-1.53 0-2.493-1.667-1.743-3.001l5.58-9.92zM10 13a1 1 0 110-2 1 1 0 010 2zm-1.75-2.5a.75.75 0 000 1.5h3.5a.75.75 0 000-1.5h-3.5z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">
                    <strong>Pengumuman:</strong> Libur nasional pada tanggal XX Bulan XXXX. <a href="#" class="font-medium underline text-yellow-700 hover:text-yellow-600">Baca selengkapnya.</a>
                </p>
            </div>
        </div>
    </div>


</div>
@endsection