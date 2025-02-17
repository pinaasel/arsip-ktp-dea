@extends('layouts.app')

@section('title', 'Daftar Tugas - Arsip KTP')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-primary">
                <i class="fas fa-tasks me-2"></i>Daftar Tugas Saya
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporans as $laporan)
                        <tr>
                            <td>#{{ str_pad($laporan->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $laporan->created_at->format('d/m/Y') }}</td>
                            <td>{{ $laporan->ktp->nik ?? '-' }}</td>
                            <td>{{ $laporan->ktp->nama_lengkap ?? '-' }}</td>
                            <td>
                                <span class="badge rounded-pill bg-{{ 
                                    $laporan->status === 'selesai' ? 'success' : 
                                    ($laporan->status === 'diproses' ? 'warning' : 'danger') 
                                }}">
                                    {{ ucfirst($laporan->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('petugas.tugas.show', $laporan) }}" 
                                   class="btn btn-sm btn-info rounded-pill">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted">Belum ada tugas</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-end mt-3">
                {{ $laporans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
