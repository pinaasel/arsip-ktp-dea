<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Str;

class TrackUserActivity
{
    protected function getReadableDescription(Request $request)
    {
        $path = $request->path();
        $segments = explode('/', $path);
        
        // Deteksi logout
        if ($path === 'logout' || Str::contains($request->fullUrl(), 'logout')) {
            return ucfirst(auth()->user()->role) . ' keluar dari sistem';
        }
        
        // Jika user adalah petugas
        if (auth()->user()->role === 'petugas') {
            // Khusus untuk route petugas/tugas/{id}
            if ($segments[0] === 'petugas' && 
                isset($segments[1]) && $segments[1] === 'tugas' && 
                isset($segments[2]) && is_numeric($segments[2])) {
                return 'Petugas mengakses detail Tugas';
            }
            
            // Khusus untuk route petugas/tugas
            if ($segments[0] === 'petugas' && 
                isset($segments[1]) && $segments[1] === 'tugas' && 
                !isset($segments[2])) {
                return 'Petugas mengakses daftar Tugas';
            }
            
            // Khusus untuk route petugas/ktp/{id}
            if ($segments[0] === 'petugas' && 
                isset($segments[1]) && $segments[1] === 'ktp' && 
                isset($segments[2]) && is_numeric($segments[2])) {
                return 'Petugas mengakses detail KTP';
            }
            
            // Khusus untuk route petugas/ktp
            if ($segments[0] === 'petugas' && 
                isset($segments[1]) && $segments[1] === 'ktp' && 
                !isset($segments[2])) {
                return 'Petugas mengakses daftar KTP';
            }
            
            // Khusus untuk route petugas/dashboard
            if ($segments[0] === 'petugas' && 
                isset($segments[1]) && $segments[1] === 'dashboard') {
                return 'Petugas mengakses Dashboard';
            }
            
            // Khusus untuk route petugas/profile
            if ($segments[0] === 'petugas' && 
                isset($segments[1]) && $segments[1] === 'profile') {
                return 'Petugas mengakses Profil';
            }
        }
        
        // Jika user adalah admin
        if (auth()->user()->role === 'admin') {
            // Khusus untuk route admin/ktp/{id}
            if ($segments[0] === 'admin' && 
                isset($segments[1]) && $segments[1] === 'ktp' && 
                isset($segments[2]) && is_numeric($segments[2])) {
                return 'Admin mengakses detail KTP';
            }
            
            // Khusus untuk route admin/ktp
            if ($segments[0] === 'admin' && 
                isset($segments[1]) && $segments[1] === 'ktp' && 
                !isset($segments[2])) {
                return 'Admin mengakses daftar KTP';
            }
            
            // Khusus untuk route admin/laporan/{id}
            if ($segments[0] === 'admin' && 
                isset($segments[1]) && $segments[1] === 'laporan' && 
                isset($segments[2]) && is_numeric($segments[2])) {
                return 'Admin mengakses detail Laporan';
            }
            
            // Khusus untuk route admin/laporan
            if ($segments[0] === 'admin' && 
                isset($segments[1]) && $segments[1] === 'laporan' && 
                !isset($segments[2])) {
                return 'Admin mengakses daftar Laporan';
            }
            
            // Khusus untuk route admin/petugas/{id}
            if ($segments[0] === 'admin' && 
                isset($segments[1]) && $segments[1] === 'petugas' && 
                isset($segments[2]) && is_numeric($segments[2])) {
                return 'Admin mengakses detail Petugas';
            }
            
            // Khusus untuk route admin/petugas
            if ($segments[0] === 'admin' && 
                isset($segments[1]) && $segments[1] === 'petugas' && 
                !isset($segments[2])) {
                return 'Admin mengakses daftar Petugas';
            }
            
            // Khusus untuk route admin/dashboard
            if ($segments[0] === 'admin' && 
                isset($segments[1]) && $segments[1] === 'dashboard') {
                return 'Admin mengakses Dashboard';
            }
            
            // Khusus untuk route admin/activity-logs
            if ($segments[0] === 'admin' && 
                isset($segments[1]) && $segments[1] === 'activity-logs') {
                return 'Admin mengakses daftar log aktivitas';
            }
        }

        // Default description jika tidak ada yang cocok
        return ucfirst(auth()->user()->role) . ' mengakses halaman ' . $path;
    }

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (auth()->check()) {
            $lastLog = ActivityLog::where('user_id', auth()->id())
                ->latest('last_seen_at')
                ->first();

            // Tentukan activity_type berdasarkan kondisi
            $activityType = 'page_view';
            if ($lastLog && $lastLog->last_seen_at && $lastLog->last_seen_at->diffInMinutes(now()) > 5) {
                $activityType = 'login';
            }
            
            // Jika ini adalah request logout
            if ($request->path() === 'logout' || Str::contains($request->fullUrl(), 'logout')) {
                $activityType = 'logout';
            }

            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity_type' => $activityType,
                'last_seen_at' => now(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'description' => $this->getReadableDescription($request),
                'properties' => []
            ]);
        }

        return $response;
    }
}
