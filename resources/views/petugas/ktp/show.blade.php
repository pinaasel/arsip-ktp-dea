@extends('layouts.app')

@section('title', 'Detail KTP')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail KTP</h3>
                    <div class="card-tools">
                        <a href="{{ route('petugas.ktp.index') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NIK</label>
                                <p class="form-control-static">{{ $ktp->nik }}</p>
                            </div>
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <p class="form-control-static">{{ $ktp->nama_lengkap }}</p>
                            </div>
                            <div class="form-group">
                                <label>Tempat, Tanggal Lahir</label>
                                <p class="form-control-static">{{ $ktp->tempat_lahir }}, {{ $ktp->tanggal_lahir->format('d F Y') }}</p>
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <p class="form-control-static">{{ $ktp->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>
                            <div class="form-group">
                                <label>Golongan Darah</label>
                                <p class="form-control-static">{{ $ktp->golongan_darah ?: '-' }}</p>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <p class="form-control-static">{{ $ktp->alamat }}</p>
                            </div>
                            <div class="form-group">
                                <label>RT/RW</label>
                                <p class="form-control-static">{{ $ktp->rt_rw }}</p>
                            </div>
                            <div class="form-group">
                                <label>Kelurahan/Desa</label>
                                <p class="form-control-static">{{ $ktp->kel_desa }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kecamatan</label>
                                <p class="form-control-static">{{ $ktp->kecamatan }}</p>
                            </div>
                            <div class="form-group">
                                <label>Agama</label>
                                <p class="form-control-static">{{ $ktp->agama }}</p>
                            </div>
                            <div class="form-group">
                                <label>Status Perkawinan</label>
                                <p class="form-control-static">{{ $ktp->status_perkawinan }}</p>
                            </div>
                            <div class="form-group">
                                <label>Pekerjaan</label>
                                <p class="form-control-static">{{ $ktp->pekerjaan }}</p>
                            </div>
                            <div class="form-group">
                                <label>Kewarganegaraan</label>
                                <p class="form-control-static">{{ $ktp->kewarganegaraan }}</p>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <p class="form-control-static">
                                    <span class="badge badge-{{ $ktp->status == 'aktif' ? 'success' : 'danger' }}">
                                        {{ ucfirst($ktp->status) }}
                                    </span>
                                </p>
                            </div>
                            <div class="form-group">
                                <label>Berlaku Hingga</label>
                                <p class="form-control-static">{{ $ktp->berlaku_hingga->format('d F Y') }}</p>
                            </div>
                            <div class="form-group">
                                <label>Foto KTP</label>
                                <div>
                                    @if($ktp->foto_ktp)
                                        <img src="{{ asset('storage/'.$ktp->foto_ktp) }}" alt="Foto KTP" class="img-fluid" style="max-width: 300px;">
                                    @else
                                        <p class="text-muted">Tidak ada foto</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted">
                                <small>
                                    Dibuat oleh: {{ $ktp->creator->name ?? '-' }} pada {{ $ktp->created_at->format('d F Y H:i') }}<br>
                                    Diperbarui oleh: {{ $ktp->updater->name ?? '-' }} pada {{ $ktp->updated_at->format('d F Y H:i') }}
                                </small>
                            </p>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('petugas.ktp.edit', $ktp->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('petugas.ktp.destroy', $ktp->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
