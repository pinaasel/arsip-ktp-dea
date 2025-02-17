@extends('layouts.app')

@section('title', 'Dashboard - Arsip KTP')

@section('content')
<div class="container">
    <div class="row">
        <!-- Statistik Card -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>
                        Statistik
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Total KTP -->
                        <div class="col-md-3 mb-3">
                            <div class="stat-card bg-info">
                                <div class="stat-card-body">
                                    <i class="fas fa-id-card fa-2x mb-2"></i>
                                    <h3>{{ $stats['total_ktp'] ?? 0 }}</h3>
                                    <p>Total KTP</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Total Petugas -->
                        <div class="col-md-3 mb-3">
                            <div class="stat-card bg-success">
                                <div class="stat-card-body">
                                    <i class="fas fa-user-tie fa-2x mb-2"></i>
                                    <h3>{{ $stats['total_petugas'] ?? 0 }}</h3>
                                    <p>Petugas</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Laporan Selesai -->
                        <div class="col-md-3 mb-3">
                            <div class="stat-card bg-warning">
                                <div class="stat-card-body">
                                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                                    <h3>{{ $stats['laporan_selesai'] ?? 0 }}</h3>
                                    <p>Laporan Selesai</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Laporan Pending -->
                        <div class="col-md-3 mb-3">
                            <div class="stat-card bg-danger">
                                <div class="stat-card-body">
                                    <i class="fas fa-clock fa-2x mb-2"></i>
                                    <h3>{{ $stats['laporan_pending'] ?? 0 }}</h3>
                                    <p>Laporan Pending</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik dan Tabel -->
        <div class="col-md-8">
            <!-- Grafik -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2"></i>
                        Grafik Laporan
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="reportChart" style="width: 100%; height: 300px;"></canvas>
                </div>
            </div>

            <!-- Laporan Terbaru -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>
                        Laporan Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>KTP</th>
                                    <th>Petugas</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latest_reports ?? [] as $index => $report)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $report->ktp->nama_lengkap }}</td>
                                    <td>{{ $report->petugas->name }}</td>
                                    <td>
                                        <span class="badge bg-{{ 
                                            $report->status === 'selesai' ? 'success' : 
                                            ($report->status === 'proses' ? 'warning' : 'danger') 
                                        }}">
                                            {{ ucfirst($report->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $report->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada laporan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Kanan -->
        <div class="col-md-4">
            <!-- Petugas Aktif -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users me-2"></i>
                        Petugas Aktif
                    </h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($active_officers ?? [] as $officer)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">{{ $officer->name }}</h6>
                                <small class="text-muted">{{ $officer->email }}</small>
                            </div>
                            <span class="badge bg-success rounded-pill">
                                {{ $officer->active_reports_count }} Tugas
                            </span>
                        </li>
                        @empty
                        <li class="list-group-item text-center">Tidak ada petugas aktif</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-link me-2"></i>
                        Quick Links
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.ktp.create') }}" class="btn btn-outline-primary">
                                <i class="fas fa-plus-circle me-2"></i>
                                Tambah KTP
                            </a>
                            <a href="{{ route('admin.laporan.create') }}" class="btn btn-outline-success">
                                <i class="fas fa-file-alt me-2"></i>
                                Buat Laporan
                            </a>
                            <a href="{{ route('admin.petugas.create') }}" class="btn btn-outline-info">
                                <i class="fas fa-user-plus me-2"></i>
                                Tambah Petugas
                            </a>
                        @else
                            <a href="{{ route('petugas.laporan.assigned') }}" class="btn btn-outline-primary">
                                <i class="fas fa-tasks me-2"></i>
                                Lihat Tugas Saya
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .stat-card {
        padding: 1.5rem;
        border-radius: 8px;
        color: white;
        text-align: center;
        transition: transform 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-card h3 {
        font-size: 2rem;
        margin: 0.5rem 0;
    }

    .stat-card p {
        margin-bottom: 0;
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .list-group-item {
        transition: background-color 0.3s;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('reportChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chart_data['labels'] ?? []) !!},
            datasets: [{
                label: 'Laporan per Hari',
                data: {!! json_encode($chart_data['data'] ?? []) !!},
                borderColor: '#3498db',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection
