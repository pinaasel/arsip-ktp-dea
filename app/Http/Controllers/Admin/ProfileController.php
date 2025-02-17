<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $totalKtp = \App\Models\Ktp::count();
        $totalPetugas = \App\Models\User::where('role', 'petugas')->count();
        
        return view('admin.profile.show', compact('user', 'totalKtp', 'totalPetugas'));
    }
    
    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto) {
                Storage::delete('public/' . $user->foto);
            }
            
            // Upload foto baru
            $foto = $request->file('foto');
            $fotoPath = $foto->store('profile-photos', 'public');
            $user->foto = $fotoPath;
        }
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->alamat = $request->alamat;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        return redirect()
            ->route('admin.profile.show')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}
