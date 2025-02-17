@extends('layouts.app')

@section('title', 'Data Petugas - Arsip KTP')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="card-title">Data Petugas</h1>
            <a href="{{ route('admin.petugas.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Tambah Petugas
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Total Laporan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($petugas as $p)
                    <tr>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->email }}</td>
                        <td>{{ $p->no_hp }}</td>
                        <td>
                            <span class="badge bg-info">
                                {{ $p->laporans_count ?? 0 }} Laporan
                            </span>
                        </td>
                        <td>
                            @php
                                $activeReports = $p->laporans()->where('status', 'proses')->count();
                            @endphp
                            <span class="badge bg-{{ $activeReports > 0 ? 'warning' : 'success' }}">
                                {{ $activeReports > 0 ? $activeReports . ' Tugas Aktif' : 'Tersedia' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.petugas.show', $p) }}" 
                                   class="btn btn-sm btn-info">
                                    <i class="fas fa-eye me-1"></i>
                                    Detail
                                </a>
                                <a href="{{ route('admin.petugas.edit', $p) }}" 
                                   class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit me-1"></i>
                                    Edit
                                </a>
                                <form action="{{ route('admin.petugas.destroy', $p) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus petugas ini?');"
                                      style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash me-1"></i>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data petugas</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $petugas->links() }}
        </div>
    </div>
</div>

@push('styles')
<style>
    .btn-group {
        gap: 0.25rem;
    }
    .badge {
        font-weight: 500;
    }
</style>
@endpush
@endsection
