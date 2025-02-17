@extends('layouts.app')

@section('title', 'Edit KTP - Arsip KTP')

@section('content')
@php
    \Log::info('View Data:', [
        'id' => $ktp->id,
        'kota' => $ktp->kota,
        'provinsi' => $ktp->provinsi,
        'kode_pos' => $ktp->kode_pos
    ]);
@endphp
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Edit Data KTP</h2>
    </div>

    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.ktp.update', $ktp->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-section">
                <h3>Data Pribadi</h3>

                <div class="form-group">
                    <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                    <input type="text" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror"
                           value="{{ old('nik', $ktp->nik) }}" required maxlength="16" minlength="16">
                    <div class="form-text">NIK harus 16 digit</div>
                    @error('nik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" 
                        class="form-control @error('nama_lengkap') is-invalid @enderror"
                        value="{{ old('nama_lengkap', $ktp->nama_lengkap) }}" required>
                    <div class="form-text">Nama lengkap harus diisi</div>
                    @error('nama_lengkap')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" 
                               class="form-control @error('tempat_lahir') is-invalid @enderror"
                               value="{{ old('tempat_lahir', $ktp->tempat_lahir) }}" required>
                        <div class="form-text">Tempat lahir harus diisi</div>
                        @error('tempat_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" 
                               class="form-control @error('tanggal_lahir') is-invalid @enderror"
                               value="{{ old('tanggal_lahir', $ktp->tanggal_lahir->format('Y-m-d')) }}" required
                               max="{{ date('Y-m-d', strtotime('-17 years')) }}">
                        <div class="form-text">Minimal berusia 17 tahun</div>
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" id="jenis_kelamin" 
                                class="form-control @error('jenis_kelamin') is-invalid @enderror" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" {{ old('jenis_kelamin', $ktp->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $ktp->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        <div class="form-text">Jenis kelamin harus dipilih</div>
                        @error('jenis_kelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="golongan_darah" class="form-label">Golongan Darah <span class="text-danger">*</span></label>
                        <select name="golongan_darah" id="golongan_darah" 
                                class="form-control @error('golongan_darah') is-invalid @enderror" required>
                            <option value="">Pilih Golongan Darah</option>
                            @foreach(['A', 'B', 'AB', 'O', '-'] as $goldar)
                                <option value="{{ $goldar }}" {{ old('golongan_darah', $ktp->golongan_darah) == $goldar ? 'selected' : '' }}>
                                    {{ $goldar }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">Golongan darah harus dipilih</div>
                        @error('golongan_darah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="agama" class="form-label">Agama <span class="text-danger">*</span></label>
                        <select name="agama" id="agama" class="form-control @error('agama') is-invalid @enderror" required>
                            <option value="">Pilih Agama</option>
                            @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'] as $agama)
                                <option value="{{ $agama }}" {{ old('agama', $ktp->agama) == $agama ? 'selected' : '' }}>
                                    {{ $agama }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">Agama harus dipilih</div>
                        @error('agama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>Alamat</h3>
                
                <div class="form-group">
                    <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                    <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" 
                              required rows="2">{{ old('alamat', $ktp->alamat) }}</textarea>
                    <div class="form-text">Alamat harus diisi</div>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="rt_rw" class="form-label">RT/RW <span class="text-danger">*</span></label>
                        <input type="text" name="rt_rw" id="rt_rw" 
                               class="form-control @error('rt_rw') is-invalid @enderror"
                               value="{{ old('rt_rw', $ktp->rt_rw) }}" required maxlength="10">
                        <div class="form-text">Format: RT/RW (contoh: 001/002)</div>
                        @error('rt_rw')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="kel_desa" class="form-label">Kelurahan/Desa <span class="text-danger">*</span></label>
                        <input type="text" name="kel_desa" id="kel_desa" 
                               class="form-control @error('kel_desa') is-invalid @enderror"
                               value="{{ old('kel_desa', $ktp->kel_desa) }}" required>
                        @error('kel_desa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="kecamatan" class="form-label">Kecamatan <span class="text-danger">*</span></label>
                        <input type="text" name="kecamatan" id="kecamatan" 
                               class="form-control @error('kecamatan') is-invalid @enderror"
                               value="{{ old('kecamatan', $ktp->kecamatan) }}" required>
                        <div class="form-text">Kecamatan harus diisi</div>
                        @error('kecamatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="kota" class="form-label">Kota/Kabupaten <span class="text-danger">*</span></label>
                        <input type="text" name="kota" id="kota" class="form-control @error('kota') is-invalid @enderror"
                               value="{{ old('kota', $ktp->kota) }}" required>
                        <div class="form-text">Kota harus diisi</div>
                        @error('kota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="provinsi" class="form-label">Provinsi <span class="text-danger">*</span></label>
                        <input type="text" name="provinsi" id="provinsi" class="form-control @error('provinsi') is-invalid @enderror"
                               value="{{ old('provinsi', $ktp->provinsi) }}" required>
                        <div class="form-text">Provinsi harus diisi</div>
                        @error('provinsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="kode_pos" class="form-label">Kode Pos <span class="text-danger">*</span></label>
                        <input type="text" name="kode_pos" id="kode_pos" class="form-control @error('kode_pos') is-invalid @enderror"
                               value="{{ old('kode_pos', $ktp->kode_pos) }}" required maxlength="5">
                        <div class="form-text">Kode pos harus 5 digit</div>
                        @error('kode_pos')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="berlaku_hingga" class="form-label">Berlaku Hingga <span class="text-danger">*</span></label>
                        <input type="date" name="berlaku_hingga" id="berlaku_hingga" 
                               class="form-control @error('berlaku_hingga') is-invalid @enderror"
                               value="{{ old('berlaku_hingga', $ktp->berlaku_hingga ? $ktp->berlaku_hingga->format('Y-m-d') : '') }}" 
                               required min="{{ date('Y-m-d') }}">
                        <div class="form-text">Tanggal harus lebih dari hari ini</div>
                        @error('berlaku_hingga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>Informasi Tambahan</h3>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="pekerjaan" class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                        <input type="text" name="pekerjaan" id="pekerjaan" 
                               class="form-control @error('pekerjaan') is-invalid @enderror"
                               value="{{ old('pekerjaan', $ktp->pekerjaan) }}" required>
                        <div class="form-text">Pekerjaan harus diisi</div>
                        @error('pekerjaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="status_perkawinan" class="form-label">Status Perkawinan <span class="text-danger">*</span></label>
                        <select name="status_perkawinan" id="status_perkawinan" 
                                class="form-control @error('status_perkawinan') is-invalid @enderror" required>
                            <option value="">Pilih Status Perkawinan</option>
                            @foreach(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $status)
                                <option value="{{ $status }}" {{ old('status_perkawinan', $ktp->status_perkawinan) == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">Status perkawinan harus dipilih</div>
                        @error('status_perkawinan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="kewarganegaraan" class="form-label">Kewarganegaraan <span class="text-danger">*</span></label>
                        <select name="kewarganegaraan" id="kewarganegaraan" 
                                class="form-control @error('kewarganegaraan') is-invalid @enderror" required>
                            <option value="">Pilih Kewarganegaraan</option>
                            <option value="WNI" {{ old('kewarganegaraan', $ktp->kewarganegaraan) == 'WNI' ? 'selected' : '' }}>WNI</option>
                            <option value="WNA" {{ old('kewarganegaraan', $ktp->kewarganegaraan) == 'WNA' ? 'selected' : '' }}>WNA</option>
                        </select>
                        <div class="form-text">Kewarganegaraan harus dipilih</div>
                        @error('kewarganegaraan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="status" class="form-label">Status KTP <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="aktif" {{ old('status', $ktp->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status', $ktp->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        <div class="form-text">Status KTP harus dipilih</div>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="foto_ktp" class="form-label">Foto KTP</label>
                        @if($ktp->foto_ktp && Storage::disk('public')->exists($ktp->foto_ktp))
                            <div class="mb-2">
                                <img src="{{ Storage::disk('public')->url($ktp->foto_ktp) }}" 
                                     alt="Foto KTP Saat Ini" 
                                     class="img-thumbnail" 
                                     style="max-height: 200px; width: auto;">
                            </div>
                        @endif
                        <input type="file" name="foto_ktp" id="foto_ktp" 
                            class="form-control @error('foto_ktp') is-invalid @enderror"
                            accept="image/*">
                        <small class="form-text text-muted">
                            Format yang didukung: JPG, JPEG, PNG. Maksimal ukuran: 2MB
                        </small>
                        @error('foto_ktp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.ktp.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<style>
.card {
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border: none;
    margin-bottom: 2rem;
}

.card-header {
    background-color: #fff;
    border-bottom: 2px solid #f0f0f0;
    padding: 1.5rem;
}

.card-title {
    color: #2d3748;
    font-size: 1.5rem;
    margin: 0;
    font-weight: 600;
}

.card-body {
    padding: 2rem;
}

.form-section {
    background: #fff;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.form-section h3 {
    color: #2d3748;
    font-size: 1.25rem;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f0f0f0;
    font-weight: 600;
}

.form-label {
    font-weight: 500;
    color: #4a5568;
    margin-bottom: 0.5rem;
}

.form-control {
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 0.625rem 0.75rem;
    transition: all 0.2s ease;
}

.form-control:focus {
    border-color: #4299e1;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.15);
}

.form-control.is-invalid {
    border-color: #e53e3e;
}

.invalid-feedback {
    color: #e53e3e;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.form-text {
    color: #718096;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.form-row {
    margin-right: -0.75rem;
    margin-left: -0.75rem;
}

.form-row > .col,
.form-row > [class*="col-"] {
    padding-right: 0.75rem;
    padding-left: 0.75rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.current-photo {
    background-color: #f7fafc;
    padding: 1rem;
    border-radius: 8px;
    text-align: center;
    margin-bottom: 1rem;
    border: 2px dashed #e2e8f0;
}

.current-photo img {
    max-width: 100%;
    height: auto;
    border-radius: 6px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.form-actions {
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 2px solid #f0f0f0;
    display: flex;
    gap: 1rem;
}

.btn {
    padding: 0.625rem 1.25rem;
    font-weight: 500;
    border-radius: 6px;
    transition: all 0.2s ease;
}

.btn-primary {
    background-color: #4299e1;
    border-color: #4299e1;
}

.btn-primary:hover {
    background-color: #3182ce;
    border-color: #3182ce;
}

.btn-secondary {
    background-color: #718096;
    border-color: #718096;
}

.btn-secondary:hover {
    background-color: #4a5568;
    border-color: #4a5568;
}

.alert {
    border-radius: 6px;
    margin-bottom: 1.5rem;
}

.alert-danger {
    background-color: #fff5f5;
    border-color: #feb2b2;
    color: #c53030;
}

.alert-danger ul {
    padding-left: 1rem;
}

select.form-control {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%234a5568'%3e%3cpath d='M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 1rem;
    padding-right: 2.5rem;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

.text-danger {
    color: #e53e3e;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card-body {
        padding: 1.5rem;
    }

    .form-section {
        padding: 1rem;
    }

    .form-row {
        margin-right: -0.5rem;
        margin-left: -0.5rem;
    }

    .form-row > .col,
    .form-row > [class*="col-"] {
        padding-right: 0.5rem;
        padding-left: 0.5rem;
    }
}
</style>
@endsection
