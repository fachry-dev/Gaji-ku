<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Absensi;
use Carbon\Carbon;

class KaryawanDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $karyawan = $user->karyawan; // Mendapatkan data karyawan yang login

        if (!$karyawan) {
            // Handle jika data karyawan tidak terkait dengan user, meskipun seharusnya tidak terjadi
            // setelah login karyawan berhasil.
            Auth::logout(); // Logout user untuk keamanan
            return redirect()->route('login')->with('error', 'Data karyawan tidak ditemukan. Silakan hubungi admin.');
        }

        // Status Presensi Hari Ini
        $today = Carbon::today();
        $absensiHariIni = Absensi::where('karyawan_id', $karyawan->id)
                                ->whereDate('tanggal', $today)
                                ->first();

        // Ringkasan Absensi Bulan Ini (Contoh Sederhana)
        $awalBulanIni = Carbon::now()->startOfMonth();
        $akhirBulanIni = Carbon::now()->endOfMonth();

        $jumlahHadirBulanIni = Absensi::where('karyawan_id', $karyawan->id)
                                    ->whereBetween('tanggal', [$awalBulanIni, $akhirBulanIni])
                                    ->where('status_kehadiran', 'hadir') // Pastikan status 'hadir'
                                    ->whereNotNull('jam_masuk') // Atau cek jam_masuk tidak null
                                    ->count();

        // Untuk 'alpha' bisa lebih kompleks, tergantung bagaimana Anda menandai alpha.
        // Misalnya, jika 'alpha' adalah default saat tidak ada record absensi
        // atau ada record dengan status 'alpha'.
        // Untuk contoh ini, kita bisa tampilkan jumlah hari kerja - hadir,
        // tapi jumlah hari kerja bulan ini perlu diketahui.
        // Kita sederhanakan dengan hanya menampilkan hadir.

        return view('karyawan.dashboard', compact(
            'karyawan',
            'absensiHariIni',
            'jumlahHadirBulanIni'
        ));
    }
}