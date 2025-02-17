@extends('layouts.app')

@section('title', 'Daftar Laporan')

@push('styles')
<style>
    .badge {
        color: #000 !important;
        font-weight: 500;
    }
    .badge-danger {
        background-color: #ffcdd2 !important;
    }
    .badge-warning {
        background-color: #fff3cd !important;
    }
    .badge-info {
        background-color: #cce5ff !important;
    }
    .badge-success {
        background-color: #d4edda !important;
    }
    .badge-primary {
        background-color: #e8eaff !important;
    }
    .badge-secondary {
        background-color: #e2e3e5 !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Laporan</h1>
        <a href="{{ route('admin.laporan.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Laporan
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Jenis Laporan</th>
                            <th>Status</th>
                            <th>Petugas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laporans as $index => $laporan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $laporan->created_at->format('d/m/Y') }}</td>
                            <td>{{ $laporan->ktp->nik }}</td>
                            <td>{{ $laporan->ktp->nama_lengkap }}</td>
                            <td>
                                <span class="badge {{ $laporan->jenis_laporan_badge_class }} px-3 py-2">
                                    {{ $laporan->jenis_laporan_label }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $laporan->status_badge_class }} px-3 py-2">
                                    {{ $laporan->status_label }}
                                </span>
                            </td>
                            <td>{{ $laporan->petugas->name }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.laporan.show', $laporan->id) }}" 
                                       class="btn btn-info btn-sm" 
                                       title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.laporan.edit', $laporan->id) }}" 
                                       class="btn btn-warning btn-sm"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.laporan.destroy', $laporan->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-danger btn-sm"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $laporans->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "ordering": false,
            "searching": false,
            "paging": false,
            "info": false
        });
    });
</script>
@endpush
