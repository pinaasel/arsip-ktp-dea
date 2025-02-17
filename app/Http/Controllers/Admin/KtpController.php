<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ktp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Log;
use App\Helpers\PdfHelper;
use Barryvdh\DomPDF\Facade\Pdf;

class KtpController extends Controller
{
    public function index()
    {
        try {
            $ktps = Ktp::latest()->paginate(10);
            
            if (auth()->user()->role === 'admin') {
                return view('admin.ktp.index', compact('ktps'));
            } else {
                return view('petugas.ktp.index', compact('ktps'));
            }
        } catch (\Exception $e) {
            Log::error('Error in KTP index: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengambil data KTP.');
        }
    }

    public function create()
    {
        try {
            if (auth()->user()->role === 'admin') {
                return view('admin.ktp.create');
            } else {
                return view('petugas.ktp.create');
            }
        } catch (\Exception $e) {
            Log::error('Error in KTP create: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat membuka form tambah KTP.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nik' => 'required|string|size:16|unique:ktps,nik',
                'nama_lengkap' => 'required|string|max:255',
                'tempat_lahir' => 'required|string|max:255',
                'tanggal_lahir' => 'required|date|before:-17 years',
                'jenis_kelamin' => 'required|in:L,P',
                'golongan_darah' => 'required|in:A,B,AB,O,-',
                'alamat' => 'required|string',
                'rt_rw' => 'required|string|max:10',
                'kel_desa' => 'required|string|max:255',
                'kecamatan' => 'required|string|max:255',
                'kota' => 'required|string|max:255',
                'provinsi' => 'required|string|max:255',
                'kode_pos' => 'required|string|max:5',
                'agama' => 'required|string|max:255',
                'status_perkawinan' => 'required|string|max:255',
                'pekerjaan' => 'required|string|max:255',
                'kewarganegaraan' => 'required|string|max:255',
                'foto_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'berlaku_hingga' => 'required|date|after:today',
                'status' => 'required|in:aktif,tidak_aktif'
            ]);

            if ($request->hasFile('foto_ktp')) {
                // Hapus foto lama jika ada
                if ($ktp->foto_ktp) {
                    Storage::disk('public')->delete($ktp->foto_ktp);
                }
                
                // Upload foto baru
                $foto = $request->file('foto_ktp');
                $filename = time() . '_' . str_replace(' ', '_', $foto->getClientOriginalName());
                $path = $foto->storeAs('foto_ktp', $filename, 'public');
                $validated['foto_ktp'] = $path;
                
                // Log untuk debug
                \Log::info('Photo upload details:', [
                    'original_name' => $foto->getClientOriginalName(),
                    'stored_path' => $path,
                    'full_url' => asset('storage/' . $path)
                ]);
            }

            $validated['petugas_id'] = auth()->id();
            
            Ktp::create($validated);

            $redirectRoute = auth()->user()->role === 'admin' ? 'admin.ktp.index' : 'petugas.ktp.index';
            return redirect()->route($redirectRoute)->with('success', 'Data KTP berhasil ditambahkan.');

        } catch (\Exception $e) {
            Log::error('Error in KTP store: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data KTP.')
                        ->withInput();
        }
    }

    public function show(Ktp $ktp)
    {
        try {
            if (auth()->user()->role === 'admin') {
                return view('admin.ktp.show', compact('ktp'));
            } else {
                return view('petugas.ktp.show', compact('ktp'));
            }
        } catch (\Exception $e) {
            Log::error('Error in KTP show: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menampilkan detail KTP.');
        }
    }

    public function edit(Ktp $ktp)
    {
        // Ensure we're loading fresh data from the database
        $ktp = $ktp->fresh();
        
        // Debug the data
        \Log::info('KTP Edit Data:', $ktp->toArray());
        
        return view('admin.ktp.edit', compact('ktp'));
    }

    public function update(Request $request, Ktp $ktp)
    {
        \Log::info('Update Request Data:', [
            'id' => $ktp->id,
            'kota' => $request->kota,
            'provinsi' => $request->provinsi,
            'kode_pos' => $request->kode_pos
        ]);

        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:ktps,nik,' . $ktp->id,
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date|before:-17 years',
            'jenis_kelamin' => 'required|in:L,P',
            'golongan_darah' => 'required|in:A,B,AB,O,-',
            'alamat' => 'required|string',
            'rt_rw' => 'required|string|max:10',
            'kel_desa' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kode_pos' => 'required|string|max:5',
            'agama' => 'required|string|max:255',
            'status_perkawinan' => 'required|string|max:255',
            'pekerjaan' => 'required|string|max:255',
            'kewarganegaraan' => 'required|string|max:255',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'berlaku_hingga' => 'required|date|after:today',
            'status' => 'required|in:aktif,tidak_aktif'
        ]);

        \Log::info('Validated Data:', [
            'kota' => $validated['kota'],
            'provinsi' => $validated['provinsi'],
            'kode_pos' => $validated['kode_pos']
        ]);

        if ($request->hasFile('foto_ktp')) {
            // Hapus foto lama jika ada
            if ($ktp->foto_ktp) {
                Storage::disk('public')->delete($ktp->foto_ktp);
            }
            
            // Upload foto baru
            $foto = $request->file('foto_ktp');
            $filename = time() . '_' . str_replace(' ', '_', $foto->getClientOriginalName());
            $path = $foto->storeAs('foto_ktp', $filename, 'public');
            $validated['foto_ktp'] = $path;
        }

        $ktp->update($validated);

        \Log::info('After Update:', [
            'kota' => $ktp->fresh()->kota,
            'provinsi' => $ktp->fresh()->provinsi,
            'kode_pos' => $ktp->fresh()->kode_pos
        ]);

        return redirect()->route('admin.ktp.index')
            ->with('success', 'Data KTP berhasil diperbarui');
    }

    public function destroy(Ktp $ktp)
    {
        try {
            if ($ktp->foto_ktp) {
                Storage::disk('public')->delete($ktp->foto_ktp);
            }
            
            $ktp->delete();

            $redirectRoute = auth()->user()->role === 'admin' ? 'admin.ktp.index' : 'petugas.ktp.index';
            return redirect()->route($redirectRoute)->with('success', 'Data KTP berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error('Error in KTP destroy: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus data KTP.');
        }
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $ktps = Ktp::with('petugas')
            ->where('nik', 'like', "%{$query}%")
            ->orWhere('nama_lengkap', 'like', "%{$query}%")
            ->latest()
            ->paginate(10);

        return view('admin.ktp.index', compact('ktps'));
    }

    public function exportPage()
    {
        return view('admin.ktp.export');
    }

    public function exportAll()
    {
        try {
            $ktps = Ktp::all();
            
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            
            // Set document information
            $pdf->SetCreator('Arsip KTP');
            $pdf->SetAuthor('Admin');
            $pdf->SetTitle('LAPORAN DATA KTP');
            
            // Remove default header/footer
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            
            // Set margins
            $pdf->SetMargins(15, 15, 15);
            
            // Add a page
            $pdf->AddPage();
            
            // Set font
            $pdf->SetFont('helvetica', '', 11);
            
            $html = view('admin.ktp.pdf.list', compact('ktps'))->render();
            
            // Print text using writeHTMLCell()
            $pdf->writeHTML($html, true, false, true, false, '');
            
            // Close and output PDF document
            $pdf->Output('daftar-ktp.pdf', 'D');
            exit;

        } catch (\Exception $e) {
            Log::error('Error saat mengexport data KTP', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat mengexport data KTP: ' . $e->getMessage());
        }
    }

    public function exportPDF(Request $request)
    {
        try {
            if ($request->has('id')) {
                $ktp = Ktp::findOrFail($request->id);
                
                $pdf = PDF::loadView('ktp.pdf', compact('ktp'));
                return $pdf->download('ktp-' . $ktp->nik . '.pdf');
                
            } else {
                $ktps = Ktp::latest()->get();
                $title = 'LAPORAN DATA KTP';
                $periode = 'Per Tanggal: ' . date('d/m/Y');
                
                $pdf = PDF::loadView('ktp.pdf-list', compact('ktps', 'title', 'periode'));
                return $pdf->download('daftar-ktp.pdf');
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat mengexport PDF: ' . $e->getMessage());
        }
    }

    public function exportBulanan($year, $month)
    {
        try {
            $ktps = Ktp::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->get();
            
            $title = 'LAPORAN BULANAN DATA KTP';
            $periode = 'Periode: ' . date('F Y', mktime(0, 0, 0, $month, 1, $year));

            // Create new PDF document
            $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
            
            // Set document information
            $pdf->SetCreator('Arsip KTP');
            $pdf->SetAuthor('Admin');
            $pdf->SetTitle($title);
            
            // Remove default header/footer
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            
            // Set margins
            $pdf->SetMargins(15, 15, 15);
            
            // Add a page
            $pdf->AddPage();
            
            // Set font
            $pdf->SetFont('helvetica', '', 11);
            
            $html = view('admin.ktp.pdf.list', compact('ktps', 'title', 'periode'))->render();
            
            // Print text using writeHTMLCell()
            $pdf->writeHTML($html, true, false, true, false, '');
            
            // Close and output PDF document
            $pdf->Output('Laporan_KTP_' . $year . '_' . $month . '.pdf', 'D');
            exit;
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mencetak laporan bulanan: ' . $e->getMessage());
        }
    }

    public function exportTahunan($year)
    {
        try {
            $ktps = Ktp::whereYear('created_at', $year)
                ->get();
            
            $title = 'LAPORAN TAHUNAN DATA KTP';
            $periode = 'Tahun: ' . $year;

            // Create new PDF document
            $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
            
            // Set document information
            $pdf->SetCreator('Arsip KTP');
            $pdf->SetAuthor('Admin');
            $pdf->SetTitle($title);
            
            // Remove default header/footer
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            
            // Set margins
            $pdf->SetMargins(15, 15, 15);
            
            // Add a page
            $pdf->AddPage();
            
            // Set font
            $pdf->SetFont('helvetica', '', 11);
            
            $html = view('admin.ktp.pdf.list', compact('ktps', 'title', 'periode'))->render();
            
            // Print text using writeHTMLCell()
            $pdf->writeHTML($html, true, false, true, false, '');
            
            // Close and output PDF document
            $pdf->Output('Laporan_KTP_' . $year . '.pdf', 'D');
            exit;
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mencetak laporan tahunan: ' . $e->getMessage());
        }
    }

    public function toggleStatus(Ktp $ktp)
    {
        try {
            $ktp->status = $ktp->status === 'aktif' ? 'nonaktif' : 'aktif';
            $ktp->save();

            return back()->with('success', 'Status KTP berhasil diubah menjadi ' . $ktp->status);
        } catch (\Exception $e) {
            Log::error('Error in KTP toggleStatus: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengubah status KTP.');
        }
    }
}
