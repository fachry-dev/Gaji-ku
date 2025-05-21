<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;

    protected $fillable = [
        'karyawan_id',
        'bulan',
        'tahun',
        'gaji_pokok_saat_itu',
        'total_hari_kerja',
        'total_hadir',
        'total_alpha',
        'potongan_per_alpha',
        'total_potongan',
        'gaji_bersih',
        'keterangan_pembayaran',
        'tanggal_pembayaran',
    ];

    protected $casts = [
        'gaji_pokok_saat_itu' => 'decimal:2',
        'potongan_per_alpha' => 'decimal:2',
        'total_potongan' => 'decimal:2',
        'gaji_bersih' => 'decimal:2',
        'tanggal_pembayaran' => 'date',
    ];

    // Relasi ke Karyawan (Satu Gaji dimiliki oleh satu Karyawan)
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
