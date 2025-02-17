<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ktp;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Data untuk cards
            $total_ktp = Ktp::count();
            $total_petugas = User::where('role', 'petugas')->count();
            $ktp_bulan_ini = Ktp::whereMonth('created_at', Carbon::now()->month)
                               ->whereYear('created_at', Carbon::now()->year)
                               ->count();

            // Data untuk tabel KTP terbaru
            $ktp_terbaru = Ktp::with('petugas')
                             ->latest()
                             ->take(5)
                             ->get();

            // Data untuk grafik
            $chart_data = [];
            $chart_labels = [];
            
            for ($i = 1; $i <= 12; $i++) {
                $chart_labels[] = Carbon::create()->month($i)->format('F');
                $count = Ktp::whereMonth('created_at', $i)
                           ->whereYear('created_at', Carbon::now()->year)
                           ->count();
                $chart_data[] = $count;
            }

            return view('admin.dashboard', compact(
                'total_ktp',
                'total_petugas',
                'ktp_bulan_ini',
                'ktp_terbaru',
                'chart_data',
                'chart_labels'
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memuat dashboard.');
        }
    }

    public function petugas()
    {
        try {
            $totalKtpDiinput = Ktp::where('petugas_id', auth()->id())->count();
            $latestKtp = Ktp::where('petugas_id', auth()->id())
                           ->latest()
                           ->take(5)
                           ->get();

            return view('petugas.dashboard', compact(
                'totalKtpDiinput',
                'latestKtp'
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memuat dashboard.');
        }
    }
}
