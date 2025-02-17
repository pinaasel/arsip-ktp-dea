@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-id-card text-primary me-2"></i>
                    Detail KTP
                </h2>
                <div>
                    @can('update', $ktp)
                    <a href="{{ route('ktp.edit', $ktp) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    @endcan
                    <a href="{{ route('admin.ktp.export', ['id' => $ktp->id]) }}" class="btn btn-info" target="_blank">
                        <i class="fas fa-file-pdf me-1"></i> Export PDF
                    </a>
                    <a href="{{ route('admin.ktp.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Foto KTP -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-image me-2"></i>
                                Foto KTP
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            @if($ktp->foto_ktp)
                                <img src="{{ asset('storage/' . $ktp->foto_ktp) }}" 
                                     alt="Foto KTP {{ $ktp->nama_lengkap }}" 
                                     class="img-fluid w-100 object-fit-cover">
                                @if(config('app.debug'))
                                    <div class="small text-muted p-2">
                                        Debug: {{ asset('storage/' . $ktp->foto_ktp) }}
                                    </div>
                                @endif
                            @else
                                <div class="alert alert-info m-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Foto KTP tidak tersedia
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Informasi KTP -->
                <div class="col-md-8">
                    <!-- Status Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="p-3 rounded-circle {{ $ktp->status == 'aktif' ? 'bg-success' : 'bg-danger' }} text-white">
                                        <i class="fas {{ $ktp->status == 'aktif' ? 'fa-check' : 'fa-times' }} fa-2x"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <h6 class="text-muted mb-1">Status KTP</h6>
                                    <h4 class="mb-0">{{ ucfirst($ktp->status) }}</h4>
                                </div>
                                <div class="col-auto">
                                    <div class="text-end">
                                        <h6 class="text-muted mb-1">Berlaku Hingga</h6>
                                        <h5 class="mb-0">{{ $ktp->berlaku_hingga->format('d F Y') }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Pribadi -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user me-2"></i>
                                Data Pribadi
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-sm">
                                        <tr>
                                            <td class="text-muted" width="40%">NIK</td>
                                            <td class="fw-bold">{{ $ktp->nik }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Nama Lengkap</td>
                                            <td class="fw-bold">{{ $ktp->nama_lengkap }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Tempat Lahir</td>
                                            <td>{{ $ktp->tempat_lahir }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Tanggal Lahir</td>
                                            <td>{{ $ktp->tanggal_lahir->format('d F Y') }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm">
                                        <tr>
                                            <td class="text-muted" width="40%">Jenis Kelamin</td>
                                            <td>{{ $ktp->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Gol. Darah</td>
                                            <td>{{ $ktp->golongan_darah }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Agama</td>
                                            <td>{{ $ktp->agama }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Status</td>
                                            <td>{{ $ktp->status_perkawinan }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                Alamat
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <p class="text-muted mb-1">Alamat Lengkap</p>
                                <p class="lead mb-0">{{ $ktp->alamat }}</p>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-sm">
                                        <tr>
                                            <td class="text-muted" width="40%">RT/RW</td>
                                            <td>{{ $ktp->rt }}/{{ $ktp->rw }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Kel/Desa</td>
                                            <td>{{ $ktp->kelurahan }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Kecamatan</td>
                                            <td>{{ $ktp->kecamatan }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm">
                                        <tr>
                                            <td class="text-muted" width="40%">Kota</td>
                                            <td>{{ $ktp->kota }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Provinsi</td>
                                            <td>{{ $ktp->provinsi }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Kode Pos</td>
                                            <td>{{ $ktp->kode_pos }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Tambahan -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Informasi Tambahan
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-sm">
                                        <tr>
                                            <td class="text-muted" width="40%">Pekerjaan</td>
                                            <td>{{ $ktp->pekerjaan }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Kewarganegaraan</td>
                                            <td>{{ $ktp->kewarganegaraan }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm">
                                        <tr>
                                            <td class="text-muted" width="40%">Dibuat Oleh</td>
                                            <td>{{ $ktp->petugas->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Dibuat Pada</td>
                                            <td>{{ $ktp->created_at->format('d F Y H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        border: none;
        transition: all 0.3s ease;
    }

    .card-header {
        border-bottom: none;
    }

    .card-header.bg-primary {
        background-color: #4299e1 !important;
    }

    .object-fit-cover {
        object-fit: cover;
        height: 300px !important;
    }

    .table.table-sm td {
        padding: 0.5rem;
        border-color: #f0f0f0;
    }

    .text-muted {
        color: #718096 !important;
    }

    .lead {
        font-size: 1.1rem;
    }

    .rounded-circle {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .bg-success {
        background-color: #48bb78 !important;
    }

    .bg-danger {
        background-color: #f56565 !important;
    }

    .shadow-sm {
        box-shadow: 0 1px 3px rgba(0,0,0,0.1) !important;
    }
</style>
@endpush
@endsection
