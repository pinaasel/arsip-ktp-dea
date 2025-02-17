@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Export Data</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <!-- Export KTP -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-id-card me-2"></i>Export Data KTP
                    </h6>
                </div>
                <div class="card-body">
                    <form id="ktpExportForm" action="{{ route('admin.export.ktp') }}" method="GET" target="_blank">
                        <div class="mb-4">
                            <label class="form-label required">Periode</label>
                            <select name="period" id="ktp_period" class="form-select" required>
                                <option value="">Pilih Periode</option>
                                <option value="daily">Harian</option>
                                <option value="monthly">Bulanan</option>
                                <option value="yearly">Tahunan</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label required">Tanggal</label>
                            <input type="date" name="date" id="ktp_date" class="form-control" required>
                            <div class="form-text">
                                Untuk periode Harian: pilih tanggal spesifik<br>
                                Untuk periode Bulanan: pilih tanggal berapapun dalam bulan yang diinginkan<br>
                                Untuk periode Tahunan: pilih tanggal berapapun dalam tahun yang diinginkan
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-file-export me-2"></i>Export PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Export Laporan -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-file-alt me-2"></i>Export Data Laporan
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.export.laporan') }}" method="GET" target="_blank">
                        <div class="mb-4">
                            <label class="form-label required">Periode</label>
                            <select name="period" id="laporan_period" class="form-select" required>
                                <option value="">Pilih Periode</option>
                                <option value="daily">Harian</option>
                                <option value="monthly">Bulanan</option>
                                <option value="yearly">Tahunan</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label required">Tanggal</label>
                            <input type="date" name="date" id="laporan_date" class="form-control" required>
                            <div class="form-text">
                                Untuk periode Harian: pilih tanggal spesifik<br>
                                Untuk periode Bulanan: pilih tanggal berapapun dalam bulan yang diinginkan<br>
                                Untuk periode Tahunan: pilih tanggal berapapun dalam tahun yang diinginkan
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Jenis Laporan</label>
                            <select name="jenis_laporan" id="jenis_laporan" class="form-select">
                                <option value="">Semua Jenis</option>
                                <option value="kehilangan">Kehilangan</option>
                                <option value="kerusakan">Kerusakan</option>
                                <option value="perbaikan_data">Perbaikan Data</option>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-file-export me-2"></i>Export PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle form submission
    document.getElementById('ktpExportForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const period = document.getElementById('ktp_period').value;
        const date = document.getElementById('ktp_date').value;
        
        if (!period || !date) {
            alert('Mohon lengkapi semua field yang diperlukan');
            return;
        }
        
        // Open in new tab
        const baseUrl = "{{ route('admin.export.ktp') }}";
        const url = `${baseUrl}?period=${period}&date=${date}`;
        window.open(url, '_blank');
    });
});
</script>
@endpush

@push('styles')
<style>
.breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
}

.breadcrumb-item a {
    color: #2B3467;
    text-decoration: none;
}

.breadcrumb-item.active {
    color: #6c757d;
}

.form-label.required:after {
    content: " *";
    color: #dc3545;
}

.card {
    border: 1px solid rgba(0,0,0,.05);
    box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
}

.card-header {
    border-bottom: 1px solid rgba(0,0,0,.05);
}

.form-control:focus,
.form-select:focus {
    border-color: #2B3467;
    box-shadow: 0 0 0 0.25rem rgba(43, 52, 103, 0.25);
}

.btn-primary {
    background-color: #2B3467;
    border-color: #2B3467;
}

.btn-primary:hover {
    background-color: #232a52;
    border-color: #232a52;
}

.form-text {
    color: #6c757d;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.text-primary {
    color: #2B3467 !important;
}
</style>
@endpush
