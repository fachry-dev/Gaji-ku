@extends('layouts.app')

@section('title', 'Form Hitung Gaji Bulanan')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-700">Hitung Gaji Karyawan</h1>
            <a href="{{ route('admin.gaji.index') }}" class="text-sm text-blue-600 hover:text-blue-800">← Kembali ke Daftar Gaji</a>
        </div>

        <form action="{{ route('admin.gaji.proses_hitung') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memproses perhitungan gaji untuk periode ini? Proses ini mungkin memerlukan waktu dan tidak dapat dibatalkan dengan mudah.');">
            @csrf
            <div class="space-y-6">
                <div>
                    <label for="bulan" class="block text-sm font-medium text-gray-700">Pilih Bulan Gaji</label>
                    <select name="bulan" id="bulan" required
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        @foreach ($listBulan as $nomor => $namaBulan)
                            <option value="{{ $nomor }}" {{ old('bulan', \Carbon\Carbon::now()->month) == $nomor ? 'selected' : '' }}>
                                {{ $namaBulan }}
                            </option>
                        @endforeach
                    </select>
                    @error('bulan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="tahun" class="block text-sm font-medium text-gray-700">Pilih Tahun Gaji</label>
                    <select name="tahun" id="tahun" required
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        @foreach ($listTahun as $thn)
                            <option value="{{ $thn }}" {{ old('tahun', \Carbon\Carbon::now()->year) == $thn ? 'selected' : '' }}>
                                {{ $thn }}
                            </option>
                        @endforeach
                    </select>
                    @error('tahun') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="total_hari_kerja" class="block text-sm font-medium text-gray-700">Total Hari Kerja dalam Sebulan</label>
                    <input type="number" name="total_hari_kerja" id="total_hari_kerja" value="{{ old('total_hari_kerja', 22) }}" required min="1" max="31"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <p class="mt-1 text-xs text-gray-500">Jumlah hari kerja efektif dalam periode gaji yang dipilih.</p>
                    @error('total_hari_kerja') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="potongan_per_alpha" class="block text-sm font-medium text-gray-700">Nilai Potongan per Hari Alpha (Tidak Hadir)</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">Rp</span>
                        </div>
                        <input type="number" name="potongan_per_alpha" id="potongan_per_alpha" value="{{ old('potongan_per_alpha', 50000) }}" required min="0" step="1000"
                               class="block w-full pl-10 pr-3 py-2 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="0">
                    </div>
                     @error('potongan_per_alpha') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-5">
                    <div class="flex justify-end">
                        <button type="submit"
                                class="w-full sm:w-auto ml-3 inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 0v6m0-6L9 13m8-8H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2z"></path></svg>
                            Proses Hitung Gaji
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <div class="mt-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 3.001-1.742 3.001H4.42c-1.53 0-2.493-1.667-1.743-3.001l5.58-9.92zM10 13a1 1 0 110-2 1 1 0 010 2zm-1.75-2.5a.75.75 0 000 1.5h3.5a.75.75 0 000-1.5h-3.5z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm">
                        <strong>Perhatian:</strong> Pastikan semua data absensi karyawan untuk periode yang dipilih sudah final sebelum memproses perhitungan gaji.
                        Proses ini akan menghitung gaji untuk SEMUA karyawan aktif. Jika gaji untuk periode ini sudah ada, data tidak akan digandakan (akan dilewati).
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection