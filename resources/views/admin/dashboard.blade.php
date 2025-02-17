@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-0">Dashboard Admin</h4>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <!-- Total KTP Card -->
        <div class="col-md-4">
            <div class="card stats-card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1">TOTAL KTP</h6>
                            <h2 class="mb-0">{{ $total_ktp }}</h2>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Petugas Card -->
        <div class="col-md-4">
            <div class="card stats-card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1">TOTAL PETUGAS</h6>
                            <h2 class="mb-0">{{ $total_petugas }}</h2>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- KTP Bulan Ini Card -->
        <div class="col-md-4">
            <div class="card stats-card bg-info text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1">KTP BULAN INI</h6>
                            <h2 class="mb-0">{{ $ktp_bulan_ini }}</h2>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- KTP Terbaru -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0">KTP Terbaru</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Tanggal Input</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ktp_terbaru as $ktp)
                                <tr>
                                    <td>{{ $ktp->nik }}</td>
                                    <td>{{ $ktp->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($ktp->created_at)->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.ktp.show', $ktp->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik KTP -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0">Grafik KTP per Bulan ({{ date('Y') }})</h6>
                </div>
                <div class="card-body">
                    <canvas id="ktpChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.stats-card {
    border: none;
    border-radius: 8px;
    transition: transform 0.2s;
}

.stats-card:hover {
    transform: translateY(-5px);
}

.stats-card .card-body {
    padding: 1.5rem;
}

.stats-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
}

.stats-icon i {
    font-size: 1.5rem;
    color: #fff;
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    margin-bottom: 1rem;
}

.card-header {
    background-color: #fff;
    border-bottom: 1px solid rgba(0,0,0,.05);
    padding: 1rem 1.5rem;
}

.table thead th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    background-color: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}

.table td {
    vertical-align: middle;
    padding: 0.75rem 1.5rem;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

.bg-primary {
    background-color: #2B3467 !important;
}

.bg-success {
    background-color: #28a745 !important;
}

.bg-info {
    background-color: #17a2b8 !important;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('ktpChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chart_labels) !!},
            datasets: [{
                label: 'Jumlah KTP',
                data: {!! json_encode($chart_data) !!},
                borderColor: '#2B3467',
                backgroundColor: 'rgba(43, 52, 103, 0.1)',
                borderWidth: 2,
                pointBackgroundColor: '#2B3467',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
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
