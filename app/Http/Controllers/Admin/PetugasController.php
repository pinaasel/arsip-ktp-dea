<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function index()
    {
        $petugas = User::where('role', 'petugas')
            ->latest()
            ->paginate(10);
            
        return view('admin.petugas.index', compact('petugas'));
    }

    public function create()
    {
        return view('admin.petugas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string'
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'petugas';
        
        User::create($validated);

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Petugas berhasil ditambahkan');
    }

    public function show(User $petuga)
    {
        return view('admin.petugas.show', compact('petuga'));
    }

    public function edit(User $petuga)
    {
        return view('admin.petugas.edit', compact('petuga'));
    }

    public function update(Request $request, User $petuga)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $petuga->id,
            'password' => 'nullable|string|min:8|confirmed',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string'
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $petuga->update($validated);

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Data petugas berhasil diperbarui');
    }

    public function destroy(User $petuga)
    {
        // Cek apakah petugas memiliki laporan yang terkait
        if ($petuga->laporans()->exists()) {
            return redirect()->route('admin.petugas.index')
                ->with('error', 'Petugas tidak dapat dihapus karena memiliki laporan terkait');
        }

        // Cek apakah petugas memiliki KTP yang terkait
        if ($petuga->ktps()->exists()) {
            return redirect()->route('admin.petugas.index')
                ->with('error', 'Petugas tidak dapat dihapus karena memiliki data KTP terkait');
        }

        $petuga->delete();

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Petugas berhasil dihapus');
    }

    public function assignTasks(Request $request, User $petuga)
    {
        $validated = $request->validate([
            'laporan_ids' => 'required|array',
            'laporan_ids.*' => 'exists:laporans,id'
        ]);

        $petuga->laporans()->sync($validated['laporan_ids']);

        return redirect()->route('admin.petugas.show', $petuga)
            ->with('success', 'Tugas berhasil diassign ke petugas');
    }

    public function performance(User $petuga)
    {
        $statistics = [
            'total_laporan' => $petuga->laporans()->count(),
            'laporan_selesai' => $petuga->laporans()->where('status', 'selesai')->count(),
            'laporan_proses' => $petuga->laporans()->where('status', 'proses')->count(),
            'laporan_pending' => $petuga->laporans()->where('status', 'pending')->count(),
            'total_ktp' => $petuga->ktps()->count()
        ];

        return view('admin.petugas.performance', compact('petuga', 'statistics'));
    }
}
