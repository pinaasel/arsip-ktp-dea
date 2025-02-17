@extends('layouts.app')

@section('title', 'Detail Petugas - Arsip KTP')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Petugas</h5>
                    <div>
                        <a href="{{ route('admin.petugas.edit', $petuga) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                            <i class="fas fa-trash me-1"></i>Hapus
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="200">Nama</th>
                                    <td>{{ $petuga->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $petuga->email }}</td>
                                </tr>
                                <tr>
                                    <th>No. HP</th>
                                    <td>{{ $petuga->no_hp }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $petuga->alamat }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge bg-{{ $petuga->status === 'aktif' ? 'success' : 'danger' }}">
                                            {{ $petuga->status === 'aktif' ? 'Tersedia' : 'Tidak Tersedia' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Bergabung Pada</th>
                                    <td>{{ $petuga->created_at->format('d F Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Statistik Tugas</h6>
                                    <div class="row mt-4">
                                        <div class="col-md-4">
                                            <div class="text-center">
                                                <h3 class="mb-2">{{ $petuga->laporans->count() }}</h3>
                                                <p class="text-muted mb-0">Total Tugas</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="text-center">
                                                <h3 class="mb-2">{{ $petuga->laporans->where('status', 'selesai')->count() }}</h3>
                                                <p class="text-muted mb-0">Selesai</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="text-center">
                                                <h3 class="mb-2">{{ $petuga->laporans->whereIn('status', ['pending', 'diproses'])->count() }}</h3>
                                                <p class="text-muted mb-0">Dalam Proses</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card mt-4">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">Tugas Terbaru</h6>
                                    @if($petuga->laporans->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Tanggal</th>
                                                        <th>Jenis</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($petuga->laporans->take(5) as $laporan)
                                                        <tr>
                                                            <td>{{ $laporan->created_at->format('d/m/Y') }}</td>
                                                            <td>{{ ucfirst($laporan->jenis_laporan) }}</td>
                                                            <td>
                                                                <span class="badge bg-{{ 
                                                                    $laporan->status === 'selesai' ? 'success' : 
                                                                    ($laporan->status === 'diproses' ? 'warning' : 'secondary')
                                                                }}">
                                                                    {{ ucfirst($laporan->status) }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p class="text-muted mb-0">Belum ada tugas</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<form id="deleteForm" action="{{ route('admin.petugas.destroy', $petuga) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
    function confirmDelete() {
        Swal.fire({
            title: 'Hapus Petugas?',
            text: "Data petugas akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm').submit();
            }
        });
    }
</script>
@endpush

@endsection
