<?php

namespace App\Http\Controllers;

use App\Models\Ktp;
use App\Models\Laporan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function admin()
    {
        // Hitung statistik untuk admin
        $totalKtp = Ktp::count();
        $totalPetugas = User::where('role', 'petugas')->count();
        
        // Statistik laporan
        $totalLaporan = Laporan::count();
        $laporanPending = Laporan::where('status', 'pending')->count();
        $laporanDiproses = Laporan::where('status', 'diproses')->count();
        $laporanSelesai = Laporan::where('status', 'selesai')->count();

        // Grafik laporan per bulan (12 bulan terakhir)
        $laporanPerBulan = Laporan::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('YEAR(created_at) as tahun'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('bulan', 'tahun')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->limit(12)
            ->get();

        return view('admin.dashboard', compact(
            'totalKtp',
            'totalPetugas',
            'totalLaporan',
            'laporanPending',
            'laporanDiproses',
            'laporanSelesai',
            'laporanPerBulan'
        ));
    }

    public function petugas()
    {
        $petugas = Auth::user();

        // Statistik tugas petugas
        $totalTugas = Laporan::where('petugas_id', $petugas->id)->count();
        $tugasPending = Laporan::where('petugas_id', $petugas->id)
            ->where('status', 'pending')
            ->count();
        $tugasDiproses = Laporan::where('petugas_id', $petugas->id)
            ->where('status', 'diproses')
            ->count();
        $tugasSelesai = Laporan::where('petugas_id', $petugas->id)
            ->where('status', 'selesai')
            ->count();

        // Tugas terbaru
        $tugasTerbaru = Laporan::where('petugas_id', $petugas->id)
            ->with('ktp')
            ->latest()
            ->limit(5)
            ->get();

        return view('petugas.dashboard', compact(
            'totalTugas',
            'tugasPending',
            'tugasDiproses',
            'tugasSelesai',
            'tugasTerbaru'
        ));
    }

    public function index()
    {
        if (auth()->user()->role === 'admin') {
            return $this->admin();
        }
        return $this->petugas();
    }
}
