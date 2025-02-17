@extends('layouts.app')

@section('title', 'Dashboard Petugas - Arsip KTP')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Dashboard Petugas</h2>
                <div>
                    <button id="statusBtn" 
                            class="btn {{ Auth::user()->status === 'aktif' ? 'btn-success' : 'btn-danger' }}"
                            onclick="toggleStatus()">
                        <i class="fas {{ Auth::user()->status === 'aktif' ? 'fa-toggle-on' : 'fa-toggle-off' }} me-2"></i>
                        {{ Auth::user()->status === 'aktif' ? 'Tersedia' : 'Tidak Tersedia' }}
                    </button>
                </div>
            </div>
            
            <!-- Statistik Cards -->
            <div class="row">
                <!-- Total KTP -->
                <div class="col-md-3 mb-4">
                    <div class="card bg-primary text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase mb-1">Total KTP</h6>
                                    <h2 class="mb-0">{{ $totalKtp }}</h2>
                                </div>
                                <div class="icon-circle bg-white">
                                    <i class="fas fa-id-card text-primary fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KTP Aktif -->
                <div class="col-md-3 mb-4">
                    <div class="card bg-success text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase mb-1">KTP Aktif</h6>
                                    <h2 class="mb-0">{{ $ktpAktif }}</h2>
                                </div>
                                <div class="icon-circle bg-white">
                                    <i class="fas fa-check-circle text-success fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KTP Nonaktif -->
                <div class="col-md-3 mb-4">
                    <div class="card bg-danger text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase mb-1">KTP Nonaktif</h6>
                                    <h2 class="mb-0">{{ $ktpNonaktif }}</h2>
                                </div>
                                <div class="icon-circle bg-white">
                                    <i class="fas fa-times-circle text-danger fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Laporan Pending -->
                <div class="col-md-3 mb-4">
                    <div class="card bg-warning text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase mb-1">Laporan Pending</h6>
                                    <h2 class="mb-0">{{ $laporanPending }}</h2>
                                </div>
                                <div class="icon-circle bg-white">
                                    <i class="fas fa-clock text-warning fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Input KTP Baru</h5>
                            <p class="card-text">Tambahkan data KTP baru ke dalam sistem.</p>
                            <a href="{{ route('petugas.ktp.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Tambah KTP
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Lihat Data KTP</h5>
                            <p class="card-text">Lihat dan kelola data KTP yang sudah ada.</p>
                            <a href="{{ route('petugas.ktp.index') }}" class="btn btn-info">
                                <i class="fas fa-list me-2"></i>Lihat Data
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KTP Terbaru -->
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">KTP Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>NIK</th>
                                    <th>Nama Lengkap</th>
                                    <th>Status</th>
                                    <th>Tanggal Input</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestKtp ?? [] as $ktp)
                                    <tr>
                                        <td>{{ $ktp->nik }}</td>
                                        <td>{{ $ktp->nama_lengkap }}</td>
                                        <td>
                                            <span class="badge {{ $ktp->status === 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                                {{ ucfirst($ktp->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $ktp->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('petugas.ktp.show', $ktp->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye me-1"></i>Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-3">Belum ada data KTP</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.icon-circle {
    height: 64px;
    width: 64px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card {
    border: none;
    border-radius: 0.5rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    transition: all 0.2s;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.btn {
    border-radius: 0.375rem;
}

.table {
    margin-bottom: 0;
}

.badge {
    padding: 0.5em 0.75em;
    border-radius: 0.375rem;
}
</style>

@push('scripts')
<script>
    function toggleStatus() {
        const currentStatus = '{{ Auth::user()->status }}';
        const newStatus = currentStatus === 'aktif' ? 'nonaktif' : 'aktif';
        
        // Send AJAX request
        fetch('{{ route("petugas.status.update") }}', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            // Update button appearance
            const btn = document.getElementById('statusBtn');
            if (data.status === 'aktif') {
                btn.classList.remove('btn-danger');
                btn.classList.add('btn-success');
                btn.innerHTML = '<i class="fas fa-toggle-on me-2"></i>Tersedia';
            } else {
                btn.classList.remove('btn-success');
                btn.classList.add('btn-danger');
                btn.innerHTML = '<i class="fas fa-toggle-off me-2"></i>Tidak Tersedia';
            }
            
            // Show notification
            Swal.fire({
                icon: 'success',
                title: 'Status Updated',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            });
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Gagal mengubah status',
            });
        });
    }
</script>
@endpush
@endsection
