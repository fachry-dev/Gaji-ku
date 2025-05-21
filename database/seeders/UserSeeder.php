<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $adminUser = User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Ganti dengan password aman
            'role' => 'admin',
        ]);
        // Tidak perlu data karyawan untuk admin, kecuali admin juga seorang karyawan.

        // Karyawan Contoh 1
        $karyawanUser1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan',
        ]);

        Karyawan::create([
            'user_id' => $karyawanUser1->id,
            'nip' => 'K001',
            'nama_lengkap' => 'Budi Santoso',
            'jabatan' => 'Staff IT',
            'gaji_pokok' => 5000000,
            'no_telepon' => '081234567890',
            'alamat' => 'Jl. Merdeka No. 1',
            'tanggal_masuk' => '2023-01-15',
        ]);

        // Karyawan Contoh 2
        $karyawanUser2 = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan',
        ]);

        Karyawan::create([
            'user_id' => $karyawanUser2->id,
            'nip' => 'K002',
            'nama_lengkap' => 'Siti Aminah',
            'jabatan' => 'Marketing',
            'gaji_pokok' => 5500000,
            'tanggal_masuk' => '2022-07-01',
        ]);
    }
}