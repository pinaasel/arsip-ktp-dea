@extends('layouts.app')

@section('title', 'Detail Laporan')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Laporan</h1>
        <div>
            <a href="{{ route('admin.laporan.edit', $laporan) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit
            </a>
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Laporan</h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th style="width: 200px">Status</th>
                            <td>
                                <span class="badge badge-{{ $laporan->status == 'pending' ? 'danger' : ($laporan->status == 'diproses' ? 'warning' : 'success') }}">
                                    {{ ucfirst($laporan->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Jenis Laporan</th>
                            <td>{{ $laporan->jenis_laporan_label }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Laporan</th>
                            <td>{{ optional($laporan->tanggal_laporan)->format('d/m/Y H:i') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Petugas</th>
                            <td>{{ optional($laporan->petugas)->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $laporan->keterangan }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data KTP</h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th style="width: 200px">NIK</th>
                            <td>{{ $laporan->ktp->nik }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $laporan->ktp->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <th>Tempat, Tanggal Lahir</th>
                            <td>{{ $laporan->ktp->tempat_lahir }}, {{ optional($laporan->ktp->tanggal_lahir)->format('d/m/Y') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>{{ $laporan->ktp->jenis_kelamin }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $laporan->ktp->alamat }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Laporan</h6>
                </div>
                <div class="card-body">
                    @if($laporan->jenis_laporan == 'kehilangan')
                        <table class="table">
                            <tr>
                                <th style="width: 200px">Lokasi Kehilangan</th>
                                <td>{{ $laporan->lokasi_kehilangan }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Kehilangan</th>
                                <td>{{ optional($laporan->tanggal_kehilangan)->format('d/m/Y') ?? '-' }}</td>
                            </tr>
                        </table>
                    @elseif($laporan->jenis_laporan == 'kerusakan')
                        <table class="table">
                            <tr>
                                <th style="width: 200px">Detail Kerusakan</th>
                                <td>{{ $laporan->detail_kerusakan }}</td>
                            </tr>
                            @if($laporan->foto_kerusakan)
                            <tr>
                                <th>Foto Kerusakan</th>
                                <td>
                                    <img src="{{ asset('storage/' . $laporan->foto_kerusakan) }}" 
                                         alt="Foto Kerusakan" 
                                         class="img-fluid" 
                                         style="max-width: 300px;">
                                </td>
                            </tr>
                            @endif
                        </table>
                    @elseif($laporan->jenis_laporan == 'perbaikan_data')
                        <table class="table">
                            <tr>
                                <th style="width: 200px">Alasan Pembaruan</th>
                                <td>{{ $laporan->alasan_pembaruan }}</td>
                            </tr>
                            @if($laporan->foto_pendukung)
                            <tr>
                                <th>Foto Dokumen Pendukung</th>
                                <td>
                                    <img src="{{ asset('storage/' . $laporan->foto_pendukung) }}" 
                                         alt="Foto Dokumen Pendukung" 
                                         class="img-fluid" 
                                         style="max-width: 300px;">
                                </td>
                            </tr>
                            @endif
                        </table>
                    @endif
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ route('admin.laporan.edit', $laporan) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('admin.laporan.download-pdf', $laporan) }}" class="btn btn-primary">
                                <i class="fas fa-download"></i> Download PDF
                            </a>
                        </div>
                        <form action="{{ route('admin.laporan.destroy', $laporan) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Status</h6>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateStatusModal">
                        <i class="fas fa-plus fa-sm"></i> Update Status
                    </button>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @foreach($riwayat_status as $riwayat)
                        <div class="timeline-item">
                            <div class="timeline-badge {{ $riwayat->status == 'pending' ? 'bg-danger' : ($riwayat->status == 'diproses' ? 'bg-warning' : 'bg-success') }}">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="timeline-header">
                                    {{ ucfirst($riwayat->status) }}
                                    <small class="text-muted">
                                        - {{ optional($riwayat->created_at)->format('d/m/Y H:i') ?? '-' }}
                                    </small>
                                </h6>
                                <p class="timeline-text">
                                    {{ $riwayat->catatan ?? 'Tidak ada catatan' }}
                                </p>
                                <p class="timeline-footer">
                                    <small class="text-muted">
                                        Oleh: {{ optional($riwayat->petugas)->name ?? '-' }}
                                    </small>
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-3">
                        {{ $riwayat_status->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Update Status -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" role="dialog" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.laporan.update-status', $laporan) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="updateStatusModalLabel">Update Status Laporan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="pending" {{ $laporan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="diproses" {{ $laporan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ $laporan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="catatan">Catatan</label>
                        <textarea name="catatan" id="catatan" rows="3" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding: 20px 0;
}

.timeline::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50px;
    height: 100%;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-badge {
    position: absolute;
    left: 40px;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    text-align: center;
    color: white;
    line-height: 24px;
    z-index: 1;
}

.timeline-content {
    margin-left: 90px;
    padding: 15px;
    border-radius: 4px;
    background: #f8f9fa;
}

.timeline-header {
    margin: 0;
    color: #495057;
}

.timeline-text {
    margin: 10px 0 0;
    color: #6c757d;
}

.timeline-footer {
    margin: 10px 0 0;
    color: #adb5bd;
}
</style>
@endpush
