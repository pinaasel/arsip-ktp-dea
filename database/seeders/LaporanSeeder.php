<?php

namespace Database\Seeders;

use App\Models\Laporan;
use Illuminate\Database\Seeder;

class LaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Laporan Kehilangan
        Laporan::create([
            'ktp_id' => 1,
            'petugas_id' => 2,
            'jenis_laporan' => 'kehilangan',
            'status' => 'pending',
            'keterangan' => 'KTP hilang saat berada di pasar',
            'catatan_petugas' => null,
            'no_laporan' => 'LP2025010001'
        ]);

        // Laporan Kerusakan
        Laporan::create([
            'ktp_id' => 2,
            'petugas_id' => 2,
            'jenis_laporan' => 'kerusakan',
            'status' => 'diproses',
            'keterangan' => 'KTP rusak karena terkena air',
            'catatan_petugas' => 'Sedang dalam proses verifikasi',
            'no_laporan' => 'LP2025010002'
        ]);

        // Laporan Perbaikan Data
        Laporan::create([
            'ktp_id' => 3,
            'petugas_id' => 3,
            'jenis_laporan' => 'perbaikan_data',
            'status' => 'selesai',
            'keterangan' => 'Perbaikan alamat dan status perkawinan',
            'catatan_petugas' => 'Data telah diperbaiki',
            'no_laporan' => 'LP2025010003'
        ]);

        // Laporan Kehilangan (Selesai)
        Laporan::create([
            'ktp_id' => 4,
            'petugas_id' => 3,
            'jenis_laporan' => 'kehilangan',
            'status' => 'selesai',
            'keterangan' => 'KTP hilang saat di kendaraan umum',
            'catatan_petugas' => 'KTP baru telah diterbitkan',
            'no_laporan' => 'LP2025010004'
        ]);

        // Laporan Kerusakan (Diproses)
        Laporan::create([
            'ktp_id' => 5,
            'petugas_id' => 2,
            'jenis_laporan' => 'kerusakan',
            'status' => 'diproses',
            'keterangan' => 'KTP rusak karena tercuci',
            'catatan_petugas' => 'Menunggu persetujuan kepala seksi',
            'no_laporan' => 'LP2025010005'
        ]);
    }
}
