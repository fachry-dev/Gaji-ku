<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Absensi; // Jika ingin menampilkan info absensi hari ini
use App\Models\Gaji;    // Jika ingin menampilkan info gaji
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalKaryawan = Karyawan::count();

        // Contoh: Karyawan hadir hari ini
        $karyawanHadirHariIni = Absensi::whereDate('tanggal', Carbon::today())
                                     ->whereNotNull('jam_masuk') // Asumsi jam masuk berarti hadir
                                     ->distinct('karyawan_id')
                                     ->count();

        // Contoh: Karyawan yang belum absen masuk hari ini
        // Ini lebih kompleks, perlu membandingkan daftar semua karyawan dengan yang sudah absen
        // Untuk simplifikasi, kita bisa tampilkan total karyawan aktif saja dulu.
        // $karyawanBelumAbsenHariIni = $totalKaryawan - $karyawanHadirHariIni;

        // Karyawan baru ditambahkan (misal 5 terakhir)
        $karyawanBaru = Karyawan::orderBy('created_at', 'desc')->take(5)->get();

        // Info gaji (opsional dan bisa kompleks)
        // $totalGajiBulanIni = Gaji::where('bulan', Carbon::now()->month)
        //                          ->where('tahun', Carbon::now()->year)
        //                          ->sum('gaji_bersih');

        return view('admin.dashboard', compact(
            'totalKaryawan',
            'karyawanHadirHariIni',
            'karyawanBaru'
            // 'totalGajiBulanIni'
        ));
    }
}