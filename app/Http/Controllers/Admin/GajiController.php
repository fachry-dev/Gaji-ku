<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gaji;
use App\Models\Karyawan;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GajiController extends Controller
{
    // Menampilkan daftar gaji yang sudah dihitung
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);

        $gajis = Gaji::with('karyawan')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->paginate(15);

        $listBulan = [];
        for ($m = 1; $m <= 12; $m++) {
            $listBulan[$m] = Carbon::create()->month($m)->translatedFormat('F');
        }
        $listTahun = range(Carbon::now()->year, Carbon::now()->year - 5);

        return view('admin.gaji.index', compact('gajis', 'bulan', 'tahun', 'listBulan', 'listTahun')); // Buat view
    }

    // Form untuk memilih bulan & tahun perhitungan gaji
    public function formHitungGaji()
    {
        $listBulan = [];
        for ($m = 1; $m <= 12; $m++) {
            $listBulan[$m] = Carbon::create()->month($m)->translatedFormat('F');
        }
        $listTahun = range(Carbon::now()->year, Carbon::now()->year - 5);
        return view('admin.gaji.form_hitung', compact('listBulan', 'listTahun')); // Buat view
    }

    // Proses perhitungan gaji
    public function prosesHitungGaji(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer|min:2000',
            'total_hari_kerja' => 'required|integer|min:1|max:31',
            'potongan_per_alpha' => 'required|numeric|min:0',
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $totalHariKerjaBulanIni = $request->total_hari_kerja; // Misal: 22 hari
        $potonganPerAlpha = $request->potongan_per_alpha; // Misal: 50000

        $karyawans = Karyawan::whereHas('user', function ($query) {
            $query->where('role', 'karyawan');
        })->get();

        DB::beginTransaction();
        try {
            foreach ($karyawans as $karyawan) {
                // Cek apakah gaji untuk bulan ini sudah ada
                $gajiExisting = Gaji::where('karyawan_id', $karyawan->id)
                                    ->where('bulan', $bulan)
                                    ->where('tahun', $tahun)
                                    ->first();
                if ($gajiExisting) {
                    // Bisa di-skip atau di-update, tergantung kebijakan
                    // Untuk sekarang kita skip jika sudah ada
                    continue;
                }

                $totalHadir = Absensi::where('karyawan_id', $karyawan->id)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->where('status_kehadiran', 'hadir') // Hanya hitung yang 'hadir'
                    ->count();

                // Asumsi: alpha adalah hari kerja dikurangi hadir (simplifikasi)
                // Lebih akurat jika ada status 'alpha' di absensi
                $totalAlpha = $totalHariKerjaBulanIni - $totalHadir;
                if ($totalAlpha < 0) $totalAlpha = 0; // Tidak mungkin minus

                // Jika ingin lebih detail, hitung 'alpha' dari tabel absensi
                // $totalAlpha = Absensi::where('karyawan_id', $karyawan->id)
                //     ->whereMonth('tanggal', $bulan)
                //     ->whereYear('tanggal', $tahun)
                //     ->where('status_kehadiran', 'alpha')
                //     ->count();


                $totalPotongan = $totalAlpha * $potonganPerAlpha;
                $gajiBersih = $karyawan->gaji_pokok - $totalPotongan;
                if ($gajiBersih < 0) $gajiBersih = 0; // Gaji tidak boleh minus

                Gaji::create([
                    'karyawan_id' => $karyawan->id,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'gaji_pokok_saat_itu' => $karyawan->gaji_pokok,
                    'total_hari_kerja' => $totalHariKerjaBulanIni,
                    'total_hadir' => $totalHadir,
                    'total_alpha' => $totalAlpha,
                    'potongan_per_alpha' => $potonganPerAlpha,
                    'total_potongan' => $totalPotongan,
                    'gaji_bersih' => $gajiBersih,
                ]);
            }
            DB::commit();
            return redirect()->route('admin.gaji.index', ['bulan' => $bulan, 'tahun' => $tahun])
                             ->with('success', 'Perhitungan gaji berhasil diproses.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses gaji: ' . $e->getMessage())->withInput();
        }
    }

    // Cetak slip gaji sederhana
    public function cetakSlip(Gaji $gaji)
    {
        $gaji->load('karyawan.user'); // Load relasi
        // return view('admin.gaji.slip', compact('gaji')); // Buat view slip gaji
        // Atau bisa generate PDF menggunakan library seperti DomPDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.gaji.slip', compact('gaji'));
        return $pdf->stream('slip-gaji-'.$gaji->karyawan->nip.'-'.$gaji->bulan.'-'.$gaji->tahun.'.pdf');
    }
}
