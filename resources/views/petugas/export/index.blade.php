@extends('layouts.app')

@section('title', 'Export Data - Arsip KTP')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-file-export me-2"></i>Export Data KTP
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('petugas.export.ktp') }}" method="GET" target="_blank">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label required">Periode</label>
                                <select name="periode" class="form-select" id="ktpPeriode" required>
                                    <option value="">Pilih Periode</option>
                                    <option value="harian">Harian</option>
                                    <option value="bulanan">Bulanan</option>
                                    <option value="tahunan">Tahunan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" id="ktpTanggal" required>
                                <div class="form-text" id="ktpHelpText"></div>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-file-pdf me-2"></i>Export PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-file-export me-2"></i>Export Data Laporan
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('petugas.export.laporan') }}" method="GET" target="_blank">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label required">Periode</label>
                                <select name="periode" class="form-select" id="laporanPeriode" required>
                                    <option value="">Pilih Periode</option>
                                    <option value="harian">Harian</option>
                                    <option value="bulanan">Bulanan</option>
                                    <option value="tahunan">Tahunan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" id="laporanTanggal" required>
                                <div class="form-text" id="laporanHelpText"></div>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-file-pdf me-2"></i>Export PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-label.required:after {
    content: " *";
    color: #dc3545;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // KTP Export Form
    const ktpPeriode = document.getElementById('ktpPeriode');
    const ktpTanggal = document.getElementById('ktpTanggal');
    const ktpHelpText = document.getElementById('ktpHelpText');

    ktpPeriode.addEventListener('change', function() {
        const periode = this.value;
        ktpTanggal.value = ''; // Reset tanggal

        switch(periode) {
            case 'harian':
                ktpTanggal.type = 'date';
                ktpHelpText.textContent = 'Pilih tanggal untuk export data harian';
                break;
            case 'bulanan':
                ktpTanggal.type = 'month';
                ktpHelpText.textContent = 'Pilih bulan untuk export data bulanan';
                break;
            case 'tahunan':
                ktpTanggal.type = 'number';
                ktpTanggal.min = '2000';
                ktpTanggal.max = new Date().getFullYear();
                ktpTanggal.placeholder = 'Masukkan tahun';
                ktpHelpText.textContent = 'Masukkan tahun untuk export data tahunan';
                break;
            default:
                ktpTanggal.type = 'date';
                ktpHelpText.textContent = '';
        }
    });

    // Laporan Export Form
    const laporanPeriode = document.getElementById('laporanPeriode');
    const laporanTanggal = document.getElementById('laporanTanggal');
    const laporanHelpText = document.getElementById('laporanHelpText');

    laporanPeriode.addEventListener('change', function() {
        const periode = this.value;
        laporanTanggal.value = ''; // Reset tanggal

        switch(periode) {
            case 'harian':
                laporanTanggal.type = 'date';
                laporanHelpText.textContent = 'Pilih tanggal untuk export data harian';
                break;
            case 'bulanan':
                laporanTanggal.type = 'month';
                laporanHelpText.textContent = 'Pilih bulan untuk export data bulanan';
                break;
            case 'tahunan':
                laporanTanggal.type = 'number';
                laporanTanggal.min = '2000';
                laporanTanggal.max = new Date().getFullYear();
                laporanTanggal.placeholder = 'Masukkan tahun';
                laporanHelpText.textContent = 'Masukkan tahun untuk export data tahunan';
                break;
            default:
                laporanTanggal.type = 'date';
                laporanHelpText.textContent = '';
        }
    });
});
</script>
@endpush
@endsection
