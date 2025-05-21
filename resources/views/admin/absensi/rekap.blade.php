@extends('layouts.app')

@section('title', 'Rekap Absensi Karyawan')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-700 mb-4 sm:mb-0">Rekapitulasi Absensi Karyawan</h1>
        {{-- Tambahkan tombol aksi jika perlu, misal: Export ke Excel --}}
        {{-- <button class="px-4 py-2 bg-teal-500 text-white rounded-md hover:bg-teal-600">
            Export Excel
        </button> --}}
    </div>

    <!-- Filter Bulan dan Tahun -->
    <div class="mb-6 bg-white shadow-md rounded-lg p-4">
        <form method="GET" action="{{ route('admin.absensi.rekap') }}" class="flex flex-col sm:flex-row sm:items-end sm:space-x-4 space-y-4 sm:space-y-0">
            <div>
                <label for="bulan" class="block text-sm font-medium text-gray-700">Bulan:</label>
                <select name="bulan" id="bulan" class="mt-1 block w-full sm:w-auto pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    @foreach ($listBulan as $nomor => $namaBulan)
                        <option value="{{ $nomor }}" {{ $nomor == $bulanDipilih ? 'selected' : '' }}>
                            {{ $namaBulan }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun:</label>
                <select name="tahun" id="tahun" class="mt-1 block w-full sm:w-auto pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    @foreach ($listTahun as $thn)
                        <option value="{{ $thn }}" {{ $thn == $tahunDipilih ? 'selected' : '' }}>
                            {{ $thn }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit"
                    class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Tampilkan Rekap
            </button>
        </form>
    </div>

    <!-- Tabel Rekap Absensi -->
    <div class="bg-white shadow-lg rounded-xl overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIP</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Karyawan</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Masuk</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Pulang</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                    {{-- <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th> --}}
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($absensis as $absensi)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        {{ \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('d M Y') }}
                        <span class="block text-xs text-gray-500">{{ \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('l') }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $absensi->karyawan->nip ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $absensi->karyawan->nama_lengkap ?? 'Karyawan Tidak Ditemukan' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $absensi->jam_masuk ? \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i:s') : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $absensi->jam_pulang ? \Carbon\Carbon::parse($absensi->jam_pulang)->format('H:i:s') : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                        @if ($absensi->status_kehadiran == 'hadir')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Hadir
                            </span>
                        @elseif ($absensi->status_kehadiran == 'izin')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                Izin
                            </span>
                        @elseif ($absensi->status_kehadiran == 'sakit')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Sakit
                            </span>
                        @elseif ($absensi->status_kehadiran == 'alpha')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Alpha
                            </span>
                        @else
                             <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                {{ ucfirst($absensi->status_kehadiran) }}
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 max-w-xs truncate" title="{{ $absensi->keterangan }}">
                        {{ $absensi->keterangan ?: '-' }}
                    </td>
                    {{-- Kolom Aksi (jika admin bisa edit/hapus absensi individual)
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-medium">
                        <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-2" title="Edit">
                            <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </a>
                        <button type="button" class="text-red-600 hover:text-red-900" title="Hapus">
                             <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </td>
                    --}}
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                        Tidak ada data absensi yang ditemukan untuk periode ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($absensis->hasPages())
        <div class="mt-6">
            {{ $absensis->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection