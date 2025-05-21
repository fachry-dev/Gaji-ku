@extends('layouts.app')

@section('title', 'Form Presensi')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md text-center">
    <h1 class="text-2xl font-semibold text-gray-700 mb-2">Presensi Hari Ini</h1>
    <p class="text-gray-600 mb-6">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>

    @if ($absensiHariIni && $absensiHariIni->jam_masuk)
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
            Anda sudah presensi masuk pada pukul: <strong>{{ \Carbon\Carbon::parse($absensiHariIni->jam_masuk)->format('H:i:s') }}</strong>
        </div>
    @else
        <div class="mb-4 p-4 bg-yellow-100 text-yellow-700 rounded-md">
            Anda belum melakukan presensi masuk hari ini.
        </div>
    @endif

    @if ($absensiHariIni && $absensiHariIni->jam_pulang)
        <div class="mb-4 p-4 bg-blue-100 text-blue-700 rounded-md">
            Anda sudah presensi pulang pada pukul: <strong>{{ \Carbon\Carbon::parse($absensiHariIni->jam_pulang)->format('H:i:s') }}</strong>
        </div>
    @endif

    <div class="mt-8 flex justify-center space-x-4">
        <form action="{{ route('karyawan.absensi.masuk') }}" method="POST">
            @csrf
            <button type="submit"
                    class="px-6 py-3 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75 disabled:opacity-50"
                    {{ $sudahMasuk ? 'disabled' : '' }}>
                Presensi Masuk
            </button>
        </form>

        <form action="{{ route('karyawan.absensi.pulang') }}" method="POST">
            @csrf
            <button type="submit"
                    class="px-6 py-3 bg-red-500 text-white font-semibold rounded-lg shadow-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-75 disabled:opacity-50"
                    {{ !$sudahMasuk || $sudahPulang ? 'disabled' : '' }}>
                Presensi Pulang
            </button>
        </form>
    </div>

    @if ($sudahMasuk && !$sudahPulang)
        <p class="mt-6 text-sm text-gray-500">Jangan lupa presensi pulang sebelum meninggalkan kantor.</p>
    @endif
</div>
@endsection