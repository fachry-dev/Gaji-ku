<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'karyawan_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status_kehadiran',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        // 'jam_masuk' => 'datetime:H:i:s', // Atau biarkan string jika hanya time
        // 'jam_pulang' => 'datetime:H:i:s',
    ];

    // Relasi ke Karyawan (Satu Absensi dimiliki oleh satu Karyawan)
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}