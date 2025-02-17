<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\RiwayatStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class TugasController extends Controller
{
    public function index()
    {
        $petugas = Auth::user();
        $laporans = Laporan::where('petugas_id', $petugas->id)
            ->with(['ktp'])
            ->latest()
            ->paginate(10);

        return view('petugas.tugas.index', compact('laporans'));
    }

    public function show(Laporan $laporan)
    {
        if ($laporan->petugas_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $laporan->load(['ktp', 'riwayat_status.petugas']);
        return view('petugas.tugas.show', compact('laporan'));
    }

    public function updateStatus(Request $request, Laporan $laporan)
    {
        try {
            DB::beginTransaction();

            // Log request data
            Log::info('Update status request received', [
                'request_data' => $request->all(),
                'laporan_id' => $laporan->id
            ]);

            // Validasi akses
            if ($laporan->petugas_id !== Auth::id()) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengubah status laporan ini.');
            }

            // Validasi input
            $rules = [
                'status' => 'required|in:pending,proses,selesai',
                'keterangan' => 'required|string|max:1000'
            ];

            $validated = $request->validate($rules);

            // Update laporan
            $laporan->status = $validated['status'];
            $laporan->save();

            // Tambah riwayat status
            RiwayatStatus::create([
                'laporan_id' => $laporan->id,
                'petugas_id' => Auth::id(),
                'status' => $validated['status'],
                'catatan' => $validated['keterangan']
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Status laporan berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error saat update status laporan', [
                'error' => $e->getMessage(),
                'laporan_id' => $laporan->id,
                'petugas_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui status. Silakan coba lagi.')
                ->withInput();
        }
    }
}