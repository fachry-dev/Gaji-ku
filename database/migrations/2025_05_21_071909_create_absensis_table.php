<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('karyawans')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            // status bisa di-extend: 'hadir', 'izin', 'sakit', 'alpha' (jika admin bisa input manual)
            // Untuk presensi tombol, awalnya mungkin hanya 'hadir' (masuk/pulang)
            // Jika 'alpha' maka jam_masuk dan jam_pulang null
            $table->enum('status_kehadiran', ['hadir', 'alpha', 'izin', 'sakit'])->default('alpha');
            $table->text('keterangan')->nullable(); // Untuk alasan izin/sakit
            $table->timestamps();

            $table->unique(['karyawan_id', 'tanggal']); // Satu karyawan hanya bisa absen sekali sehari
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};