<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gajis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('karyawans')->onDelete('cascade');
            $table->unsignedTinyInteger('bulan'); // 1-12
            $table->unsignedSmallInteger('tahun'); // Misal: 2024
            $table->decimal('gaji_pokok_saat_itu', 15, 2); // Gaji pokok karyawan pada bulan tsb
            $table->integer('total_hari_kerja')->default(0); // Jumlah hari kerja dalam sebulan (bisa diset oleh admin)
            $table->integer('total_hadir')->default(0);
            $table->integer('total_alpha')->default(0); // Total tidak hadir tanpa keterangan
            $table->decimal('potongan_per_alpha', 15, 2)->default(0); // Nilai potongan per hari alpha
            $table->decimal('total_potongan', 15, 2)->default(0);
            $table->decimal('gaji_bersih', 15, 2);
            $table->text('keterangan_pembayaran')->nullable();
            $table->date('tanggal_pembayaran')->nullable();
            $table->timestamps();

            $table->unique(['karyawan_id', 'bulan', 'tahun']); // Karyawan hanya dapat satu record gaji per bulan/tahun
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gajis');
    }
};