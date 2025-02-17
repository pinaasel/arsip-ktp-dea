@extends('layouts.app')

@section('title', 'Detail Tugas - Arsip KTP')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <!-- Detail KTP -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-id-card me-2"></i>Detail KTP
                        </h5>
                        <a href="{{ route('petugas.tugas.index') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label text-muted">NIK</label>
                            <p class="mb-0 fw-bold">{{ $laporan->ktp->nik ?? '-' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-muted">Nama Lengkap</label>
                            <p class="mb-0 fw-bold">{{ $laporan->ktp->nama_lengkap ?? '-' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-muted">Tempat Lahir</label>
                            <p class="mb-0 fw-bold">{{ $laporan->ktp->tempat_lahir ?? '-' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-muted">Tanggal Lahir</label>
                            <p class="mb-0 fw-bold">{{ $laporan->ktp->tanggal_lahir ? \Carbon\Carbon::parse($laporan->ktp->tanggal_lahir)->format('d/m/Y') : '-' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-muted">Jenis Kelamin</label>
                            <p class="mb-0 fw-bold">{{ $laporan->ktp->jenis_kelamin ?? '-' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-muted">Golongan Darah</label>
                            <p class="mb-0 fw-bold">{{ $laporan->ktp->golongan_darah ?? '-' }}</p>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted">Alamat</label>
                            <p class="mb-0 fw-bold">{{ $laporan->ktp->alamat ?? '-' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-muted">RT/RW</label>
                            <p class="mb-0 fw-bold">{{ $laporan->ktp->rt_rw ?? '-' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-muted">Kel/Desa</label>
                            <p class="mb-0 fw-bold">{{ $laporan->ktp->kel_desa ?? '-' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-muted">Kecamatan</label>
                            <p class="mb-0 fw-bold">{{ $laporan->ktp->kecamatan ?? '-' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-muted">Agama</label>
                            <p class="mb-0 fw-bold">{{ $laporan->ktp->agama ?? '-' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-muted">Status Perkawinan</label>
                            <p class="mb-0 fw-bold">{{ $laporan->ktp->status_perkawinan ?? '-' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-muted">Pekerjaan</label>
                            <p class="mb-0 fw-bold">{{ $laporan->ktp->pekerjaan ?? '-' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-muted">Kewarganegaraan</label>
                            <p class="mb-0 fw-bold">{{ $laporan->ktp->kewarganegaraan ?? '-' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-muted">Berlaku Hingga</label>
                            <p class="mb-0 fw-bold">{{ $laporan->ktp->berlaku_hingga ? \Carbon\Carbon::parse($laporan->ktp->berlaku_hingga)->format('d/m/Y') : '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Laporan -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-file-alt me-2"></i>Detail Laporan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label text-muted">No. Laporan</label>
                            <p class="mb-0 fw-bold">LP/{{ $laporan->created_at->format('Ym') }}/{{ str_pad($laporan->id, 4, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-muted">Jenis Laporan</label>
                            <p class="mb-0 fw-bold">{{ ucfirst($laporan->jenis_laporan) }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-muted">Tanggal Laporan</label>
                            <p class="mb-0 fw-bold">{{ $laporan->created_at ? $laporan->created_at->format('d/m/Y H:i') : '-' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-muted">Status</label>
                            <p class="mb-0">
                                @if($laporan->status === 'pending')
                                    <span class="badge bg-warning">Menunggu</span>
                                @elseif($laporan->status === 'proses')
                                    <span class="badge bg-info">Diproses</span>
                                @elseif($laporan->status === 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($laporan->status) }}</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted">Keterangan</label>
                            <p class="mb-0 fw-bold">{{ $laporan->keterangan ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Status Tugas -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-tasks me-2"></i>Status Tugas
                    </h5>
                </div>
                <div class="card-body">
                    @if($laporan->status !== 'selesai')
                    <form action="{{ route('petugas.tugas.update-status', $laporan) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-3">
                            <label class="form-label required">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="">Pilih Status</option>
                                <option value="proses" {{ $laporan->status === 'proses' ? 'selected' : '' }}>Proses</option>
                                <option value="selesai" {{ $laporan->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label required">Keterangan Update</label>
                            <textarea name="keterangan" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                    @else
                        <div class="alert alert-success mb-0">
                            <i class="fas fa-check-circle me-2"></i>Tugas telah selesai
                        </div>
                    @endif

                    <!-- Riwayat Status -->
                    <div class="mt-4">
                        <h6 class="mb-3">Riwayat Status</h6>
                        <div class="timeline">
                            @forelse($laporan->riwayat_status as $riwayat)
                            <div class="timeline-item">
                                <div class="timeline-content">
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <small class="text-muted">
                                            {{ $riwayat->created_at->format('d/m/Y H:i') }}
                                        </small>
                                    </div>
                                    <div class="d-flex align-items-center mb-1">
                                        <span class="fw-bold me-2">Status:</span>
                                        @if($riwayat->status === 'pending')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif($riwayat->status === 'proses')
                                            <span class="badge bg-info">Diproses</span>
                                        @elseif($riwayat->status === 'selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($riwayat->status) }}</span>
                                        @endif
                                    </div>
                                    <p class="mb-0">{{ $riwayat->keterangan }}</p>
                                </div>
                            </div>
                            @empty
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-info-circle me-2"></i>Belum ada riwayat status
                            </div>
                            @endforelse
                        </div>
                    </div>
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

.timeline {
    position: relative;
    padding: 0;
    list-style: none;
}

.timeline:before {
    content: '';
    position: absolute;
    top: 0;
    left: 20px;
    height: 100%;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    padding-left: 50px;
    padding-bottom: 1rem;
}

.timeline-item:before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #007bff;
}

.timeline-content {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.5rem;
}
</style>
@endsection 