<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Ktp;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller
{
    public function index()
    {
        return view('petugas.export.index');
    }

    public function exportKtp(Request $request)
    {
        $request->validate([
            'periode' => 'required|in:harian,bulanan,tahunan',
            'tanggal' => 'required'
        ]);

        $query = Ktp::query();
        
        switch ($request->periode) {
            case 'harian':
                $query->whereDate('created_at', $request->tanggal);
                $title = 'Export KTP Tanggal ' . date('d F Y', strtotime($request->tanggal));
                break;
            case 'bulanan':
                $date = date('Y-m', strtotime($request->tanggal));
                $query->whereYear('created_at', date('Y', strtotime($request->tanggal)))
                      ->whereMonth('created_at', date('m', strtotime($request->tanggal)));
                $title = 'Export KTP Bulan ' . date('F Y', strtotime($request->tanggal));
                break;
            case 'tahunan':
                $query->whereYear('created_at', $request->tanggal);
                $title = 'Export KTP Tahun ' . $request->tanggal;
                break;
        }

        $data = $query->get();
        
        return view('petugas.export.ktp-print', compact('data', 'title'));
    }

    public function printKtp(Request $request)
    {
        $petugas = Auth::user();
        $period = $request->input('period', 'daily');
        $date = $request->input('date');

        $query = Ktp::where('petugas_id', $petugas->id);

        switch ($period) {
            case 'daily':
                $query->whereDate('created_at', $date);
                $periodText = 'Tanggal ' . date('d/m/Y', strtotime($date));
                break;
            case 'monthly':
                $query->whereYear('created_at', date('Y', strtotime($date)))
                      ->whereMonth('created_at', date('m', strtotime($date)));
                $periodText = 'Bulan ' . date('F Y', strtotime($date));
                break;
            case 'yearly':
                $query->whereYear('created_at', date('Y', strtotime($date)));
                $periodText = 'Tahun ' . date('Y', strtotime($date));
                break;
        }

        $ktps = $query->get();
        
        return view('petugas.export.ktp-print', [
            'ktps' => $ktps,
            'period' => $period,
            'periodText' => $periodText,
            'petugas' => $petugas
        ]);
    }

    public function exportLaporan(Request $request)
    {
        $request->validate([
            'periode' => 'required|in:harian,bulanan,tahunan',
            'tanggal' => 'required'
        ]);

        $query = Laporan::with('ktp');
        
        switch ($request->periode) {
            case 'harian':
                $query->whereDate('created_at', $request->tanggal);
                $title = 'Export Laporan Tanggal ' . date('d F Y', strtotime($request->tanggal));
                break;
            case 'bulanan':
                $date = date('Y-m', strtotime($request->tanggal));
                $query->whereYear('created_at', date('Y', strtotime($request->tanggal)))
                      ->whereMonth('created_at', date('m', strtotime($request->tanggal)));
                $title = 'Export Laporan Bulan ' . date('F Y', strtotime($request->tanggal));
                break;
            case 'tahunan':
                $query->whereYear('created_at', $request->tanggal);
                $title = 'Export Laporan Tahun ' . $request->tanggal;
                break;
        }

        $data = $query->get();
        
        return view('petugas.export.laporan-print', compact('data', 'title'));
    }

    public function printLaporan(Request $request)
    {
        $petugas = Auth::user();
        $period = $request->input('period', 'daily');
        $date = $request->input('date');

        $query = Laporan::where('petugas_id', $petugas->id)
                       ->with(['ktp']);

        switch ($period) {
            case 'daily':
                $query->whereDate('created_at', $date);
                $periodText = 'Tanggal ' . date('d/m/Y', strtotime($date));
                break;
            case 'monthly':
                $query->whereYear('created_at', date('Y', strtotime($date)))
                      ->whereMonth('created_at', date('m', strtotime($date)));
                $periodText = 'Bulan ' . date('F Y', strtotime($date));
                break;
            case 'yearly':
                $query->whereYear('created_at', date('Y', strtotime($date)));
                $periodText = 'Tahun ' . date('Y', strtotime($date));
                break;
        }

        $laporans = $query->get();
        
        return view('petugas.export.laporan-print', [
            'laporans' => $laporans,
            'period' => $period,
            'periodText' => $periodText,
            'petugas' => $petugas
        ]);
    }
}
