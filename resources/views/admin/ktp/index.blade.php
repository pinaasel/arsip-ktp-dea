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
                                <form action="{{ route('admin.ktp.index') }}" method="GET" class="d-flex align-items-center mb-0">
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
                                <a href="{{ route('admin.ktp.export') }}" class="btn btn-success">
                                    <i class="fas fa-file-export"></i> Export PDF
                                </a>
                                <a href="{{ route('admin.ktp.create') }}" class="btn btn-primary add-button">
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
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.ktp.show', $ktp->id) }}" class="btn-action btn-view">
                                            <i class="fas fa-eye"></i>
                                            <span>Lihat</span>
                                        </a>
                                        <a href="{{ route('admin.ktp.edit', $ktp->id) }}" class="btn-action btn-edit">
                                            <i class="fas fa-edit"></i>
                                            <span>Edit</span>
                                        </a>
                                        <form action="{{ route('admin.ktp.toggle-status', $ktp->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn-action {{ $ktp->status === 'aktif' ? 'btn-warning' : 'btn-success' }}"
                                                    onclick="return confirm('Apakah Anda yakin ingin mengubah status KTP ini menjadi {{ $ktp->status === 'aktif' ? 'nonaktif' : 'aktif' }}?')">
                                                <i class="fas {{ $ktp->status === 'aktif' ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
                                                <span>{{ $ktp->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}</span>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.ktp.destroy', $ktp->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete" 
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="fas fa-trash"></i>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data KTP</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <div class="custom-pagination">
                    {{ $ktps->appends(['search' => request('search')])->links() }}
                </div>
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

    .btn-delete {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .btn-warning {
        background-color: #fef3c7;
        color: #92400e;
    }

    .btn-success {
        background-color: #d1fae5;
        color: #065f46;
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
        width: 300px;
        height: 38px;
        padding: 8px 40px 8px 15px;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        background-color: #f8fafc;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .search-input:hover {
        background-color: #f1f5f9;
    }

    .search-input:focus {
        outline: none;
        border-color: #3b82f6;
        background-color: #fff;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .search-button {
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
        padding: 6px 12px;
        color: #64748b;
        transition: color 0.2s ease;
    }

    .search-button:hover {
        color: #3b82f6;
    }

    .add-button {
        height: 38px;
        padding: 0 20px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        background-color: #3b82f6;
        border: none;
        transition: all 0.2s ease;
    }

    .add-button:hover {
        background-color: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.1), 0 2px 4px -1px rgba(37, 99, 235, 0.06);
    }
</style>
@endsection
