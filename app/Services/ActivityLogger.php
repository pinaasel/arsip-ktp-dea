<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    public static function log($type, $description)
    {
        if (!Auth::check()) {
            return;
        }

        Activity::create([
            'user_id' => Auth::id(),
            'type' => $type,
            'description' => $description,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    public static function logLogin($user)
    {
        self::log('login', "User {$user->name} logged in");
    }

    public static function logLogout($user)
    {
        self::log('logout', "User {$user->name} logged out");
    }

    public static function logKtpCreated($ktp)
    {
        self::log('create_ktp', "Created KTP for {$ktp->nama_lengkap} (NIK: {$ktp->nik})");
    }

    public static function logKtpUpdated($ktp)
    {
        self::log('update_ktp', "Updated KTP for {$ktp->nama_lengkap} (NIK: {$ktp->nik})");
    }

    public static function logKtpDeleted($ktp)
    {
        self::log('delete_ktp', "Deleted KTP for {$ktp->nama_lengkap} (NIK: {$ktp->nik})");
    }

    public static function logLaporanCreated($laporan)
    {
        self::log('create_laporan', "Created {$laporan->jenis_laporan} report for KTP {$laporan->ktp->nik}");
    }

    public static function logLaporanStatusUpdated($laporan)
    {
        self::log('update_laporan', "Updated status to {$laporan->status} for report #{$laporan->id}");
    }
}
