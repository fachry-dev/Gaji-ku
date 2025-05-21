<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji - {{ $gaji->karyawan->nama_lengkap }} - {{ \Carbon\Carbon::create()->month($gaji->bulan)->translatedFormat('F') }} {{ $gaji->tahun }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; line-height: 1.6; color: #333; font-size: 12px; margin: 0; padding: 0; }
        .container { width: 90%; margin: 20px auto; padding: 20px; border: 1px solid #ddd; box-shadow: 0 0 10px rgba(0,0,0,0.05); }
        .header { text-align: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #eee; }
        .header h1 { margin: 0; font-size: 24px; color: #2c3e50; }
        .header p { margin: 5px 0; font-size: 14px; }
        .employee-details, .salary-details { margin-bottom: 20px; }
        .employee-details table, .salary-details table { width: 100%; border-collapse: collapse; }
        .employee-details th, .employee-details td, .salary-details th, .salary-details td {
            padding: 8px 12px;
            text-align: left;
            border-bottom: 1px dotted #eee;
        }
        .employee-details th { width: 30%; background-color: #f9f9f9; font-weight: bold; }
        .salary-details th { background-color: #f9f9f9; font-weight: bold; }
        .salary-details .label { width: 60%; }
        .salary-details .amount { text-align: right; }
        .total-row td { font-weight: bold; border-top: 2px solid #333; }
        .total-row .amount { color: #27ae60; font-size: 14px; }
        .footer { text-align: center; margin-top: 30px; padding-top: 15px; border-top: 1px solid #eee; font-size: 10px; color: #777; }
        .company-name { font-weight: bold; font-size: 16px; margin-bottom: 5px;}
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            {{-- Ganti dengan nama perusahaan Anda --}}
            <div class="company-name">PT. MAJU JAYA SEJAHTERA</div>
            <p>Slip Gaji Karyawan</p>
            <p>Periode: {{ \Carbon\Carbon::create()->month($gaji->bulan)->translatedFormat('F') }} {{ $gaji->tahun }}</p>
        </div>

        <div class="employee-details">
            <table>
                <tr>
                    <th>Nama Karyawan</th>
                    <td>: {{ $gaji->karyawan->nama_lengkap }}</td>
                </tr>
                <tr>
                    <th>NIP</th>
                    <td>: {{ $gaji->karyawan->nip }}</td>
                </tr>
                <tr>
                    <th>Jabatan</th>
                    <td>: {{ $gaji->karyawan->jabatan }}</td>
                </tr>
                 <tr>
                    <th>Tanggal Cetak</th>
                    <td>: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i:s') }}</td>
                </tr>
            </table>
        </div>

        <div class="salary-details">
            <h3 style="margin-bottom: 10px; font-size:16px; color:#34495e;">Rincian Penghasilan:</h3>
            <table>
                <tr>
                    <td class="label">Gaji Pokok</td>
                    <td class="amount">Rp {{ number_format($gaji->gaji_pokok_saat_itu, 2, ',', '.') }}</td>
                </tr>
                {{-- Tambahkan komponen tunjangan lain jika ada --}}
                {{--
                <tr>
                    <td class="label">Tunjangan Transportasi</td>
                    <td class="amount">Rp {{ number_format(TAMBAHKAN_NILAI_TUNJANGAN, 2, ',', '.') }}</td>
                </tr>
                --}}
            </table>
        </div>

        <div class="salary-details">
            <h3 style="margin-bottom: 10px; font-size:16px; color:#34495e;">Rincian Potongan:</h3>
            <table>
                <tr>
                    <td class="label">Potongan Ketidakhadiran (Alpha)</td>
                    <td class="amount">Rp {{ number_format($gaji->total_potongan, 2, ',', '.') }}</td>
                </tr>
                 <tr>
                    <td class="label" style="font-style: italic; font-size: 10px;">(Total Alpha: {{ $gaji->total_alpha }} hari x Rp {{ number_format($gaji->potongan_per_alpha, 0, ',', '.') }})</td>
                    <td class="amount"></td>
                </tr>
                {{-- Tambahkan komponen potongan lain jika ada --}}
            </table>
        </div>

        <div class="salary-details">
            <table>
                <tr class="total-row">
                    <td class="label" style="font-size: 14px;">GAJI BERSIH DITERIMA (Take Home Pay)</td>
                    <td class="amount" style="font-size: 16px;">Rp {{ number_format($gaji->gaji_bersih, 2, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>Ini adalah slip gaji yang dicetak secara otomatis oleh sistem.</p>
            <p>© {{ date('Y') }} {{-- Nama Perusahaan Anda --}} PT. MAJU JAYA SEJAHTERA. All rights reserved.</p>
        </div>
    </div>
</body>
</html>