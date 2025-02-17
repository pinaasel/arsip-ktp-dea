<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ktp;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExportController extends Controller
{
    public function index()
    {
        return view('admin.export.index');
    }

    public function exportKtp(Request $request)
    {
        $request->validate([
            'period' => 'required|in:daily,monthly,yearly',
            'date' => 'required|date'
        ]);

        $date = Carbon::parse($request->date);
        $query = Ktp::query();

        switch ($request->period) {
            case 'daily':
                $query->whereDate('created_at', $date);
                $title = 'Data KTP Harian - ' . $date->format('d/m/Y');
                break;
            case 'monthly':
                $query->whereYear('created_at', $date->year)
                     ->whereMonth('created_at', $date->month);
                $title = 'Data KTP Bulanan - ' . $date->format('F Y');
                break;
            case 'yearly':
                $year = $date->year;
                \Log::info('Searching KTP for year: ' . $year);
                $query->whereYear('created_at', $year);
                $title = 'Data KTP Tahunan - ' . $year;
                break;
        }

        // Get the SQL before executing the query
        \Log::info('KTP Query:', [
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings()
        ]);

        $ktps = $query->orderBy('created_at', 'desc')->get();
        
        // Log the result count
        \Log::info('KTP results count: ' . $ktps->count());
        
        $timestamp = Carbon::now()->format('d/m/Y H:i');
        
        return view('admin.export.ktp-print', compact('ktps', 'title', 'timestamp'));
    }

    public function exportLaporan(Request $request)
    {
        $request->validate([
            'period' => 'required|in:daily,monthly,yearly',
            'date' => 'required|date',
            'jenis_laporan' => 'nullable|in:kehilangan,kerusakan,perbaikan_data'
        ]);

        $date = Carbon::parse($request->date);
        $laporans = Laporan::with(['ktp', 'petugas']);

        switch ($request->period) {
            case 'daily':
                $laporans->whereDate('created_at', $date);
                $periodText = 'Harian - ' . $date->format('d/m/Y');
                break;
            case 'monthly':
                $laporans->whereYear('created_at', $date->year)
                         ->whereMonth('created_at', $date->month);
                $periodText = 'Bulanan - ' . $date->format('F Y');
                break;
            case 'yearly':
                $laporans->whereYear('created_at', $date->year);
                $periodText = 'Tahunan - ' . $date->year;
                break;
        }

        if ($request->jenis_laporan) {
            $laporans->where('jenis_laporan', $request->jenis_laporan);
            $title = 'Data Laporan ' . ucfirst($request->jenis_laporan) . ' ' . $periodText;
        } else {
            $title = 'Data Semua Laporan ' . $periodText;
        }

        $laporans = $laporans->orderBy('created_at', 'desc')->get();
        $timestamp = Carbon::now()->format('d/m/Y H:i');
        
        return view('admin.export.laporan-print', compact('laporans', 'title', 'timestamp'));
    }
}
