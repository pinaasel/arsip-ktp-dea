<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    public function tugas()
    {
        $petugas = Auth::user();
        $laporans = Laporan::where('petugas_id', $petugas->id)
            ->with(['ktp'])
            ->latest()
            ->paginate(10);

        return view('petugas.tugas.index', compact('laporans'));
    }

    public function showTugas(Laporan $laporan)
    {
        if ($laporan->petugas_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('petugas.tugas.show', compact('laporan'));
    }

    public function updateStatus(Request $request, Laporan $laporan)
    {
        if ($laporan->petugas_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized action.'], 403);
        }

        $request->validate([
            'status' => 'required|in:pending,diproses,selesai'
        ]);

        $laporan->update([
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'Status berhasil diperbarui',
            'status' => $request->status
        ]);
    }

    public function updateKetersediaan(Request $request)
    {
        $user = Auth::user();
        
        if ($user->role !== 'petugas') {
            return response()->json(['message' => 'Unauthorized action.'], 403);
        }

        $request->validate([
            'status' => 'required|in:aktif,nonaktif'
        ]);

        $user->update([
            'status' => $request->status
        ]);

        $message = $request->status === 'aktif' ? 'Anda sekarang tersedia' : 'Anda sekarang tidak tersedia';

        return response()->json([
            'message' => $message,
            'status' => $request->status
        ]);
    }
}
