<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'ktp_id',
        'petugas_id',
        'no_laporan',
        'jenis_laporan',
        'keterangan',
        'lokasi_kehilangan',
        'tanggal_kehilangan',
        'detail_kerusakan',
        'foto_kerusakan',
        'alasan_pembaruan',
        'foto_pendukung',
        'status'
    ];

    protected $dates = [
        'tanggal_kehilangan',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'tanggal_kehilangan' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($laporan) {
            if (!$laporan->no_laporan) {
                $latestLaporan = static::latest()->first();
                $latestNumber = $latestLaporan ? intval(substr($latestLaporan->no_laporan, -4)) : 0;
                $newNumber = str_pad($latestNumber + 1, 4, '0', STR_PAD_LEFT);
                $laporan->no_laporan = 'LP' . date('Ym') . $newNumber;
            }
        });
    }

    public function ktp()
    {
        return $this->belongsTo(Ktp::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function riwayat_status()
    {
        return $this->hasMany(RiwayatStatus::class)->orderBy('created_at', 'desc');
    }

    public function getJenisLaporanLabelAttribute()
    {
        return match($this->jenis_laporan) {
            'kehilangan' => 'Kehilangan KTP',
            'kerusakan' => 'Kerusakan KTP',
            'perbaikan_data' => 'Pembaruan Data KTP',
            default => ucfirst($this->jenis_laporan)
        };
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Pending',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            default => ucfirst($this->status)
        };
    }

    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'pending' => 'badge-danger',
            'diproses' => 'badge-warning',
            'selesai' => 'badge-success',
            default => 'badge-secondary'
        };
    }
}
