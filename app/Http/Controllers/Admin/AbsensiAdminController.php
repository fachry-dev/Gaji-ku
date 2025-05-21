<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiAdminController extends Controller
{
    // ... (bagian atas controller)
public function rekapAbsensi(Request $request)
{
    $bulanDipilih = $request->input('bulan', Carbon::now()->month);
    $tahunDipilih = $request->input('tahun', Carbon::now()->year);

    $absensis = Absensi::with('karyawan.user') // Eager load karyawan dan user terkait
        ->whereMonth('tanggal', $bulanDipilih)
        ->whereYear('tanggal', $tahunDipilih)
        ->orderBy('tanggal', 'desc') // Urutkan berdasarkan tanggal terbaru dulu
        ->orderBy('karyawan_id')     // Kemudian berdasarkan karyawan
        ->paginate(25); // Sesuaikan jumlah per halaman

    $listBulan = [];
    for ($m = 1; $m <= 12; $m++) {
        $listBulan[$m] = Carbon::create()->month($m)->translatedFormat('F');
    }

    // Ambil tahun dari data absensi yang ada atau beberapa tahun ke belakang
    $tahunAbsensiDB = Absensi::selectRaw('YEAR(tanggal) as tahun')
                            ->distinct()
                            ->orderBy('tahun', 'desc')
                            ->pluck('tahun');
    $listTahun = $tahunAbsensiDB->isNotEmpty() ? $tahunAbsensiDB : collect([Carbon::now()->year]);


    return view('admin.absensi.rekap', compact('absensis', 'bulanDipilih', 'tahunDipilih', 'listBulan', 'listTahun'));
}
// ... (bagian bawah controller)

    // Opsional: Admin bisa input/edit absensi manual
    // public function createOrEditAbsensi(Request $request, $karyawan_id, $tanggal)
    // {
    //     // ... logika untuk admin menambah/mengedit data absensi karyawan tertentu
    // }
}
