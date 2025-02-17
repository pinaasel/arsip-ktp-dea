<?php

namespace App\Exports;

use App\Models\Laporan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return Laporan::with(['ktp', 'petugas', 'admin'])->get();
    }

    public function headings(): array
    {
        return [
            'ID Laporan',
            'Tanggal',
            'Jenis Laporan',
            'NIK',
            'Nama',
            'Status',
            'Petugas',
            'Admin',
            'Deskripsi',
            'Catatan'
        ];
    }

    public function map($laporan): array
    {
        return [
            str_pad($laporan->id, 5, '0', STR_PAD_LEFT),
            $laporan->created_at->format('d/m/Y H:i'),
            ucfirst($laporan->jenis_laporan),
            $laporan->ktp->nik,
            $laporan->ktp->nama_lengkap,
            ucfirst($laporan->status),
            $laporan->petugas->name,
            $laporan->admin->name,
            $laporan->deskripsi,
            $laporan->catatan ?? '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
