<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ktp;
use App\Models\Laporan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKtp = Ktp::count();
        $ktpAktif = Ktp::where('status', 'aktif')->count();
        $ktpNonaktif = Ktp::where('status', 'nonaktif')->count();
        $laporanPending = Laporan::where('status', 'pending')->count();

        return view('petugas.dashboard', compact('totalKtp', 'ktpAktif', 'ktpNonaktif', 'laporanPending'));
    }
}
