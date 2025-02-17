@extends('layouts.app')

@section('title', 'Data KTP - Arsip KTP')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-white py-3">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="m-0 font-weight-bold">Data KTP</h5>
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <form action="{{ route('petugas.ktp.index') }}" method="GET" class="d-flex align-items-center mb-0">
                                    <div class="position-relative">
                                        <input type="text" 
                                               name="search" 
                                               value="{{ request('search') }}" 
                                               class="form-control search-input" 
                                               placeholder="Cari NIK atau nama..."
                                               autocomplete="off">
                                        <button type="submit" class="btn btn-link search-button">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div>
                                <a href="{{ route('petugas.ktp.create') }}" class="btn btn-primary add-button">
                                    <i class="fas fa-plus me-2"></i>
                                    <span>Tambah KTP</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama Lengkap</th>
                            <th>Tempat Lahir</th>
                            <th>Tanggal Lahir</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ktps as $index => $ktp)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $ktp->nik }}</td>
                                <td>{{ $ktp->nama_lengkap }}</td>
                                <td>{{ $ktp->tempat_lahir }}</td>
                                <td>{{ $ktp->tanggal_lahir->format('d/m/Y') }}</td>
                                <td>
                                    <span class="status-badge {{ $ktp->status === 'aktif' ? 'status-active' : 'status-inactive' }}">
                                        {{ ucfirst($ktp->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('petugas.ktp.show', $ktp->id) }}" class="btn btn-info btn-sm" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('petugas.ktp.edit', $ktp->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('petugas.ktp.destroy', $ktp->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-3">Tidak ada data KTP</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 custom-pagination">
                {{ $ktps->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    /* Style untuk pagination */
    .custom-pagination nav {
        display: flex;
        justify-content: center;
        margin-top: 1rem;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .status-active {
        background-color: #d1fae5;
        color: #065f46;
    }

    .status-inactive {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .btn-action {
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        margin: 0 0.25rem;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-action i {
        margin-right: 0.375rem;
    }

    .btn-view {
        background-color: #e0f2fe;
        color: #0369a1;
    }

    .btn-edit {
        background-color: #fef3c7;
        color: #92400e;
    }

    .btn-action:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .search-input {
        width: 250px;
        padding-right: 40px;
    }

    .search-button {
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
        padding: 0.5rem 0.75rem;
    }

    .search-button:hover {
        color: #374151;
    }

    .add-button {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #2563eb;
        color: white;
        text-decoration: none;
        transition: all 0.2s;
    }

    .add-button:hover {
        background-color: #1d4ed8;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.1), 0 2px 4px -1px rgba(37, 99, 235, 0.06);
    }
</style>
@endsection
