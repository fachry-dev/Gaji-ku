@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Salam Pembuka -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}!</h1>
            <p class="text-gray-600">Berikut adalah ringkasan aktivitas sistem penggajian.</p>
        </div>

        <!-- Bagian Ringkasan Statistik (Overview Cards) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Card Total Karyawan -->
            <div class="bg-white shadow-lg rounded-xl p-6 flex items-center space-x-4 transform hover:scale-105 transition-transform duration-300">
                <div class="p-3 bg-blue-500 text-white rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Karyawan</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $totalKaryawan }}</p>
                </div>
            </div>

            <!-- Card Karyawan Hadir Hari Ini -->
            <div class="bg-white shadow-lg rounded-xl p-6 flex items-center space-x-4 transform hover:scale-105 transition-transform duration-300">
                <div class="p-3 bg-green-500 text-white rounded-full">
                     <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Hadir Hari Ini</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ $karyawanHadirHariIni }}</p>
                </div>
            </div>

            <!-- Card (Contoh Lain jika ada data, misal: Gaji Diproses) -->
            <div class="bg-white shadow-lg rounded-xl p-6 flex items-center space-x-4 transform hover:scale-105 transition-transform duration-300">
                 <div class="p-3 bg-yellow-500 text-white rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Gaji Diproses (Bulan Ini)</p>
                    <p class="text-2xl font-semibold text-gray-800">
                        {{-- @isset($totalGajiBulanIni) Rp {{ number_format($totalGajiBulanIni, 0, ',', '.') }} @else Belum Ada @endisset --}}
                        Belum Ada Data
                    </p>
                </div>
            </div>
        </div>

        <!-- Bagian Aksi Cepat -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Aksi Cepat</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <a href="{{ route('admin.karyawan.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-6 px-4 rounded-lg shadow-md flex flex-col items-center justify-center text-center transition duration-300">
                    <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Kelola Data Karyawan
                </a>
                <a href="{{ route('admin.absensi.rekap') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-6 px-4 rounded-lg shadow-md flex flex-col items-center justify-center text-center transition duration-300">
                    <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Lihat Rekap Absensi
                </a>
                <a href="{{ route('admin.gaji.form_hitung') }}" class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-6 px-4 rounded-lg shadow-md flex flex-col items-center justify-center text-center transition duration-300">
                    <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 0v6m0-6L9 13m8-8H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2z"></path></svg>
                    Hitung Gaji Bulanan
                </a>
            </div>
        </div>

        <!-- Bagian Karyawan Baru Ditambahkan -->
        <div class="bg-white shadow-lg rounded-xl p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Karyawan Baru Ditambahkan</h2>
            @if($karyawanBaru->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Bergabung</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($karyawanBaru as $karyawan)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $karyawan->nama_lengkap }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $karyawan->jabatan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $karyawan->created_at->translatedFormat('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.karyawan.show', $karyawan->id) }}" class="text-indigo-600 hover:text-indigo-900">Lihat Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500">Tidak ada karyawan baru yang ditambahkan baru-baru ini.</p>
            @endif
            @if ($totalKaryawan > 5)
                <div class="mt-4 text-right">
                     <a href="{{ route('admin.karyawan.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        Lihat Semua Karyawan →
                    </a>
                </div>
            @endif
        </div>

        {{-- Anda bisa menambahkan bagian lain di sini, misalnya grafik (membutuhkan library chart.js atau sejenisnya) --}}
        {{--
        <div class="mt-8 bg-white shadow-lg rounded-xl p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Grafik Kehadiran (Contoh)</h2>
            <div class="h-64">
                 Canvas untuk chart
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>
        --}}
    </div>

{{-- Jika ingin menggunakan chart, tambahkan scriptnya di sini atau di layouts/app.blade.php --}}
{{--
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Contoh data untuk chart
    const ctx = document.getElementById('attendanceChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar', // atau 'line', 'pie', dll.
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'],
                datasets: [{
                    label: '# Kehadiran',
                    data: [12, 19, 3, 5, 2], // Data dari backend
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
</script>
@endpush
--}}
@endsection