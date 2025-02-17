<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Ktp;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KtpController extends Controller
{
    public function index(Request $request)
    {
        $query = Ktp::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%");
            });
        }

        $ktps = $query->latest()->paginate(10);

        return view('petugas.ktp.index', compact('ktps'));
    }

    public function create()
    {
        return view('petugas.ktp.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => [
                'required',
                'string',
                'size:16',
                'unique:ktps',
                'regex:/^[0-9]+$/'
            ],
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'golongan_darah' => 'nullable|in:A,B,AB,O,-',
            'alamat' => 'required|string',
            'rt_rw' => 'required|string|max:10',
            'kel_desa' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu,Lainnya',
            'status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'pekerjaan' => 'required|string|max:50',
            'kewarganegaraan' => 'required|in:WNI,WNA',
            'foto_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'nik.regex' => 'NIK hanya boleh berisi angka',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid',
            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'rt_rw.required' => 'RT/RW wajib diisi',
            'kel_desa.required' => 'Kelurahan/Desa wajib diisi',
            'kecamatan.required' => 'Kecamatan wajib diisi',
            'agama.required' => 'Agama wajib diisi',
            'status_perkawinan.required' => 'Status perkawinan wajib diisi',
            'pekerjaan.required' => 'Pekerjaan wajib diisi',
            'kewarganegaraan.required' => 'Kewarganegaraan wajib diisi',
            'foto_ktp.required' => 'Foto wajib diisi',
            'foto_ktp.image' => 'File harus berupa gambar',
            'foto_ktp.mimes' => 'Format foto harus jpeg, png, atau jpg',
            'foto_ktp.max' => 'Ukuran foto maksimal 2MB'
        ]);

        if ($request->hasFile('foto_ktp')) {
            $foto = $request->file('foto_ktp');
            $fotoPath = $foto->store('public/ktp_photos');
            $validated['foto_ktp'] = str_replace('public/', '', $fotoPath);
        }

        // Set nilai default
        $validated['status'] = 'aktif';
        $validated['created_by'] = Auth::id();
        $validated['petugas_id'] = Auth::id();
        $validated['berlaku_hingga'] = now()->addYears(5);

        Ktp::create($validated);

        return redirect()
            ->route('petugas.ktp.index')
            ->with('success', 'Data KTP berhasil ditambahkan');
    }

    public function show(Ktp $ktp)
    {
        return view('petugas.ktp.show', compact('ktp'));
    }

    public function edit(Ktp $ktp)
    {
        return view('petugas.ktp.edit', compact('ktp'));
    }

    public function update(Request $request, Ktp $ktp)
    {
        $validated = $request->validate([
            'nik' => [
                'required',
                'string',
                'size:16',
                'unique:ktps,nik,' . $ktp->id,
                'regex:/^[0-9]+$/'
            ],
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'golongan_darah' => 'nullable|in:A,B,AB,O,-',
            'alamat' => 'required|string',
            'rt_rw' => 'required|string|max:10',
            'kel_desa' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu,Lainnya',
            'status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'pekerjaan' => 'required|string|max:50',
            'kewarganegaraan' => 'required|in:WNI,WNA',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'nik.regex' => 'NIK hanya boleh berisi angka',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid',
            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'rt_rw.required' => 'RT/RW wajib diisi',
            'kel_desa.required' => 'Kelurahan/Desa wajib diisi',
            'kecamatan.required' => 'Kecamatan wajib diisi',
            'agama.required' => 'Agama wajib diisi',
            'status_perkawinan.required' => 'Status perkawinan wajib diisi',
            'pekerjaan.required' => 'Pekerjaan wajib diisi',
            'kewarganegaraan.required' => 'Kewarganegaraan wajib diisi',
            'foto_ktp.image' => 'File harus berupa gambar',
            'foto_ktp.mimes' => 'Format foto harus jpeg, png, atau jpg',
            'foto_ktp.max' => 'Ukuran foto maksimal 2MB'
        ]);

        if ($request->hasFile('foto_ktp')) {
            $foto = $request->file('foto_ktp');
            $fotoPath = $foto->store('public/ktp_photos');
            $validated['foto_ktp'] = str_replace('public/', '', $fotoPath);
        }

        $validated['updated_by'] = Auth::id();
        $validated['petugas_id'] = Auth::id();

        $ktp->update($validated);

        return redirect()
            ->route('petugas.ktp.index')
            ->with('success', 'Data KTP berhasil diperbarui');
    }

    public function destroy(Ktp $ktp)
    {
        try {
            // Hapus file foto jika ada
            if ($ktp->foto_ktp && Storage::exists('public/' . $ktp->foto_ktp)) {
                Storage::delete('public/' . $ktp->foto_ktp);
            }

            // Hapus data KTP
            $ktp->delete();

            return redirect()
                ->route('petugas.ktp.index')
                ->with('success', 'Data KTP berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->route('petugas.ktp.index')
                ->with('error', 'Gagal menghapus data KTP');
        }
    }

    /**
     * Export KTP data to PDF
     */
    public function exportPDF(Request $request)
    {
        try {
            if ($request->has('id')) {
                $ktp = Ktp::findOrFail($request->id);
                
                // Verify if petugas has access to this KTP
                if ($ktp->petugas_id !== Auth::id()) {
                    return redirect()
                        ->back()
                        ->with('error', 'Anda tidak memiliki akses untuk mengexport KTP ini.');
                }
                
                $pdf = PDF::loadView('ktp.pdf', compact('ktp'));
                return $pdf->download('ktp-' . $ktp->nik . '.pdf');
                
            } else {
                // For petugas, only show KTPs they have access to
                $ktps = Ktp::where('petugas_id', Auth::id())->latest()->get();
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
}
