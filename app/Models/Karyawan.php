<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nip',
        'nama_lengkap',
        'jabatan',
        'gaji_pokok',
        'no_telepon',
        'alamat',
        'tanggal_masuk',
    ];

    protected $casts = [
        'gaji_pokok' => 'decimal:2',
        'tanggal_masuk' => 'date',
    ];

    // Relasi ke User (Satu Karyawan dimiliki oleh satu User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Absensi (Satu Karyawan punya banyak Absensi)
    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

    // Relasi ke Gaji (Satu Karyawan punya banyak Gaji)
    public function gajis()
    {
        return $this->hasMany(Gaji::class);
    }
}