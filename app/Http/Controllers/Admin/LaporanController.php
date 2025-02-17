<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\RiwayatStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        $laporans = Laporan::with(['ktp', 'petugas'])->latest()->paginate(10);
        return view('admin.laporan.index', compact('laporans'));
    }

    public function create()
    {
        $ktps = \App\Models\Ktp::where('status', 'aktif')
                    ->select('id', 'nik', 'nama_lengkap')
                    ->orderBy('nama_lengkap')
                    ->get();
        return view('admin.laporan.create', compact('ktps'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ktp_id' => 'required|exists:ktps,id',
            'jenis_laporan' => 'required|in:kehilangan,kerusakan,perbaikan_data',
            'keterangan' => 'required|string',
            'status' => 'required|in:pending,diproses,selesai'
        ]);

        // Validasi tambahan berdasarkan jenis laporan
        if ($request->jenis_laporan == 'kehilangan') {
            $request->validate([
                'lokasi_kehilangan' => 'required|string',
                'tanggal_kehilangan' => 'required|date'
            ]);
        } elseif ($request->jenis_laporan == 'kerusakan') {
            $request->validate([
                'detail_kerusakan' => 'required|string',
                'foto_kerusakan' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);
        } elseif ($request->jenis_laporan == 'perbaikan_data') {
            $request->validate([
                'alasan_pembaruan' => 'required|string',
                'foto_pendukung' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);
        }

        $validatedData['petugas_id'] = Auth::id();
        $validatedData['tanggal_laporan'] = now();

        // Upload foto jika ada
        if ($request->hasFile('foto_kerusakan')) {
            $path = $request->file('foto_kerusakan')->store('public/foto_kerusakan');
            $validatedData['foto_kerusakan'] = str_replace('public/', '', $path);
        }

        if ($request->hasFile('foto_pendukung')) {
            $path = $request->file('foto_pendukung')->store('public/foto_pendukung');
            $validatedData['foto_pendukung'] = str_replace('public/', '', $path);
        }

        $laporan = Laporan::create($validatedData);

        // Buat riwayat status awal
        RiwayatStatus::create([
            'laporan_id' => $laporan->id,
            'status' => $validatedData['status'],
            'catatan' => 'Status awal laporan',
            'petugas_id' => Auth::id()
        ]);

        return redirect()->route('admin.laporan.show', $laporan)
            ->with('success', 'Laporan berhasil dibuat!');
    }

    public function show(Laporan $laporan)
    {
        $laporan->load(['ktp', 'petugas']);
        $riwayat_status = $laporan->riwayat_status()->with('petugas')->latest()->paginate(5);
        return view('admin.laporan.show', compact('laporan', 'riwayat_status'));
    }

    public function edit(Laporan $laporan)
    {
        // Load the relationships
        $laporan->load(['ktp', 'petugas']);

        // Get KTPs and Petugas
        $ktps = \App\Models\Ktp::where('status', 'aktif')
                    ->select('id', 'nik', 'nama_lengkap')
                    ->orderBy('nama_lengkap')
                    ->get();
        
        $petugas = \App\Models\User::where('role', 'petugas')
                    ->select('id', 'name')
                    ->orderBy('name')
                    ->get();

        // Format tanggal kehilangan jika ada
        if ($laporan->tanggal_kehilangan) {
            $laporan->tanggal_kehilangan = \Carbon\Carbon::parse($laporan->tanggal_kehilangan)->startOfDay();
        }

        // Debug untuk melihat data yang dimuat
        \Log::info('Data Laporan:', [
            'id' => $laporan->id,
            'ktp_id' => $laporan->ktp_id,
            'petugas_id' => $laporan->petugas_id,
            'jenis_laporan' => $laporan->jenis_laporan,
            'keterangan' => $laporan->keterangan,
            'lokasi_kehilangan' => $laporan->lokasi_kehilangan,
            'tanggal_kehilangan' => $laporan->tanggal_kehilangan ? $laporan->tanggal_kehilangan->format('Y-m-d') : null,
            'detail_kerusakan' => $laporan->detail_kerusakan,
            'foto_kerusakan' => $laporan->foto_kerusakan,
            'alasan_pembaruan' => $laporan->alasan_pembaruan,
            'foto_pendukung' => $laporan->foto_pendukung,
            'status' => $laporan->status
        ]);

        return view('admin.laporan.edit', compact('laporan', 'ktps', 'petugas'));
    }

    public function update(Request $request, Laporan $laporan)
    {
        // Validasi input
        $validatedData = $request->validate([
            'ktp_id' => 'required|exists:ktps,id',
            'petugas_id' => 'required|exists:users,id',
            'jenis_laporan' => 'required|in:kehilangan,kerusakan,perbaikan_data',
            'keterangan' => 'required|string',
            'status' => 'required|in:pending,diproses,selesai',
            'lokasi_kehilangan' => 'required_if:jenis_laporan,kehilangan',
            'tanggal_kehilangan' => 'required_if:jenis_laporan,kehilangan|date',
            'detail_kerusakan' => 'required_if:jenis_laporan,kerusakan',
            'foto_kerusakan' => 'nullable|image|max:2048',
            'alasan_pembaruan' => 'required_if:jenis_laporan,perbaikan_data',
            'foto_pendukung' => 'nullable|image|max:2048'
        ]);

        try {
            // Siapkan data untuk update
            $dataToUpdate = [
                'ktp_id' => $request->ktp_id,
                'petugas_id' => $request->petugas_id,
                'jenis_laporan' => $request->jenis_laporan,
                'keterangan' => $request->keterangan,
                'status' => $request->status,
            ];

            // Tambahkan field berdasarkan jenis laporan
            if ($request->jenis_laporan == 'kehilangan') {
                $dataToUpdate['lokasi_kehilangan'] = $request->lokasi_kehilangan;
                $dataToUpdate['tanggal_kehilangan'] = $request->tanggal_kehilangan;
                // Reset field yang tidak digunakan
                $dataToUpdate['detail_kerusakan'] = null;
                $dataToUpdate['foto_kerusakan'] = null;
                $dataToUpdate['alasan_pembaruan'] = null;
                $dataToUpdate['foto_pendukung'] = null;
            } 
            elseif ($request->jenis_laporan == 'kerusakan') {
                $dataToUpdate['detail_kerusakan'] = $request->detail_kerusakan;
                // Handle foto kerusakan
                if ($request->hasFile('foto_kerusakan')) {
                    // Hapus foto lama jika ada
                    if ($laporan->foto_kerusakan) {
                        Storage::delete('public/' . $laporan->foto_kerusakan);
                    }
                    $dataToUpdate['foto_kerusakan'] = $request->file('foto_kerusakan')->store('foto_kerusakan', 'public');
                }
                // Reset field yang tidak digunakan
                $dataToUpdate['lokasi_kehilangan'] = null;
                $dataToUpdate['tanggal_kehilangan'] = null;
                $dataToUpdate['alasan_pembaruan'] = null;
                $dataToUpdate['foto_pendukung'] = null;
            } 
            elseif ($request->jenis_laporan == 'perbaikan_data') {
                $dataToUpdate['alasan_pembaruan'] = $request->alasan_pembaruan;
                // Handle foto pendukung
                if ($request->hasFile('foto_pendukung')) {
                    // Hapus foto lama jika ada
                    if ($laporan->foto_pendukung) {
                        Storage::delete('public/' . $laporan->foto_pendukung);
                    }
                    $dataToUpdate['foto_pendukung'] = $request->file('foto_pendukung')->store('foto_pendukung', 'public');
                }
                // Reset field yang tidak digunakan
                $dataToUpdate['lokasi_kehilangan'] = null;
                $dataToUpdate['tanggal_kehilangan'] = null;
                $dataToUpdate['detail_kerusakan'] = null;
                $dataToUpdate['foto_kerusakan'] = null;
            }

            // Update laporan
            $laporan->update($dataToUpdate);

            // Tambahkan log untuk debugging
            \Log::info('Data yang diupdate:', $dataToUpdate);

            // Buat riwayat status jika status berubah
            if ($laporan->status != $request->status) {
                \App\Models\RiwayatStatus::create([
                    'laporan_id' => $laporan->id,
                    'status' => $request->status,
                    'catatan' => 'Status diperbarui',
                    'petugas_id' => auth()->id()
                ]);
            }

            return redirect()->route('admin.laporan.index')
                ->with('success', 'Laporan berhasil diperbarui!');

        } catch (\Exception $e) {
            \Log::error('Error updating laporan: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui laporan. ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, Laporan $laporan)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai',
            'catatan' => 'required|string'
        ]);

        // Update status laporan
        $laporan->update([
            'status' => $request->status
        ]);

        // Buat riwayat status baru
        $laporan->riwayat_status()->create([
            'petugas_id' => auth()->id(),
            'status' => $request->status,
            'catatan' => $request->catatan
        ]);

        return redirect()->back()->with('success', 'Status laporan berhasil diperbarui');
    }

    public function destroy(Laporan $laporan)
    {
        // Hapus foto terkait jika ada
        if ($laporan->foto_kerusakan) {
            Storage::delete('public/' . $laporan->foto_kerusakan);
        }
        if ($laporan->foto_pendukung) {
            Storage::delete('public/' . $laporan->foto_pendukung);
        }

        $laporan->delete();

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Laporan berhasil dihapus!');
    }

    public function downloadPDF(Laporan $laporan)
    {
        // Load view dengan data
        $html = view('admin.laporan.pdf', compact('laporan'))->render();
        
        // Set header untuk download PDF
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="laporan_ktp_' . $laporan->ktp->nik . '.pdf"');
        
        // Output HTML yang akan di-print sebagai PDF oleh browser
        echo $html;
        exit;
    }
}
