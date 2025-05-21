@extends('layouts.app')

@section('title', 'Kelola Karyawan')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-semibold text-gray-700">Daftar Karyawan</h1>
    <a href="{{ route('admin.karyawan.create') }}"
       class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600">
        Tambah Karyawan
    </a>
</div>

<div class="bg-white shadow-md rounded-lg overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIP</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gaji Pokok</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($karyawans as $karyawan)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $karyawan->nip }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $karyawan->nama_lengkap }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $karyawan->user->email }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $karyawan->jabatan }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($karyawan->gaji_pokok, 0, ',', '.') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <a href="{{ route('admin.karyawan.edit', $karyawan->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                    <form action="{{ route('admin.karyawan.destroy', $karyawan->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                    Tidak ada data karyawan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@if ($karyawans->hasPages())
    <div class="mt-6">
        {{ $karyawans->links() }} {{-- Tailwind pagination views perlu di-publish: php artisan vendor:publish --tag=laravel-pagination --}}
    </div>
@endif
@endsection