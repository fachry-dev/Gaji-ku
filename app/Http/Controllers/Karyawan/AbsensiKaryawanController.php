<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsensiKaryawanController extends Controller
{
    // Menampilkan form presensi (tombol masuk/pulang) dan status hari ini
    public function formPresensi()
    {
        $karyawan = Auth::user()->karyawan;
        if (!$karyawan) {
            return redirect()->route('karyawan.dashboard')->with('error', 'Data karyawan tidak ditemukan.');
        }

        $today = Carbon::today();
        $absensiHariIni = Absensi::where('karyawan_id', $karyawan->id)
                                ->whereDate('tanggal', $today)
                                ->first();

        $sudahMasuk = $absensiHariIni && $absensiHariIni->jam_masuk;
        $sudahPulang = $absensiHariIni && $absensiHariIni->jam_pulang;

        return view('karyawan.absensi.form', compact('karyawan', 'absensiHariIni', 'sudahMasuk', 'sudahPulang')); // Buat view
    }

    public function presensiMasuk(Request $request)
    {
        $karyawan = Auth::user()->karyawan;
        if (!$karyawan) {
            return back()->with('error', 'Data karyawan tidak ditemukan.');
        }
        $today = Carbon::today();
        $now = Carbon::now();

        $absensi = Absensi::firstOrNew([
            'karyawan_id' => $karyawan->id,
            'tanggal' => $today,
        ]);

        if ($absensi->jam_masuk) {
            return back()->with('warning', 'Anda sudah melakukan presensi masuk hari ini.');
        }

        $absensi->jam_masuk = $now->format('H:i:s');
        $absensi->status_kehadiran = 'hadir'; // Set status hadir saat masuk
        $absensi->save();

        return back()->with('success', 'Presensi masuk berhasil dicatat pukul ' . $now->format('H:i:s'));
    }

    public function presensiPulang(Request $request)
    {
        $karyawan = Auth::user()->karyawan;
        if (!$karyawan) {
            return back()->with('error', 'Data karyawan tidak ditemukan.');
        }
        $today = Carbon::today();
        $now = Carbon::now();

        $absensi = Absensi::where('karyawan_id', $karyawan->id)
                        ->whereDate('tanggal', $today)
                        ->first();

        if (!$absensi || !$absensi->jam_masuk) {
            return back()->with('error', 'Anda belum melakukan presensi masuk hari ini.');
        }

        if ($absensi->jam_pulang) {
            return back()->with('warning', 'Anda sudah melakukan presensi pulang hari ini.');
        }

        $absensi->jam_pulang = $now->format('H:i:s');
        $absensi->save();

        return back()->with('success', 'Presensi pulang berhasil dicatat pukul ' . $now->format('H:i:s'));
    }

    // ... (bagian atas controller)
public function riwayatAbsensi(Request $request)
{
    $karyawan = Auth::user()->karyawan;
    if (!$karyawan) {
        return redirect()->route('karyawan.dashboard')->with('error', 'Data karyawan tidak ditemukan.');
    }

    $bulanDipilih = $request->input('bulan', Carbon::now()->month);
    $tahunDipilih = $request->input('tahun', Carbon::now()->year);

    $riwayat = Absensi::where('karyawan_id', $karyawan->id)
                    ->whereMonth('tanggal', $bulanDipilih)
                    ->whereYear('tanggal', $tahunDipilih)
                    ->orderBy('tanggal', 'desc')
                    ->paginate(15);

    $listBulan = [];
    for ($m = 1; $m <= 12; $m++) {
        $listBulan[$m] = Carbon::create()->month($m)->translatedFormat('F');
    }
    // Ambil tahun dari data absensi karyawan tersebut atau beberapa tahun ke belakang
    $tahunAbsensi = Absensi::where('karyawan_id', $karyawan->id)
                            ->selectRaw('YEAR(tanggal) as tahun')
                            ->distinct()
                            ->orderBy('tahun', 'desc')
                            ->pluck('tahun');
    $listTahun = $tahunAbsensi->isNotEmpty() ? $tahunAbsensi : collect([Carbon::now()->year]);


    return view('karyawan.absensi.riwayat', compact('riwayat', 'karyawan', 'bulanDipilih', 'tahunDipilih', 'listBulan', 'listTahun'));
}
// ... (bagian bawah controller)
}