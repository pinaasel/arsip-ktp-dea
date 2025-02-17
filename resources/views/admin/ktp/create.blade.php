@extends('layouts.app')

@section('title', 'Tambah Data KTP - Arsip KTP')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Tambah Data KTP</h2>
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

        <form action="{{ route('admin.ktp.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-section">
                <h3>Data Pribadi</h3>
                
                <div class="form-group">
                    <label for="nik" class="form-label">NIK</label>
                    <input type="text" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror"
                           value="{{ old('nik') }}" required maxlength="16" minlength="16">
                    <div class="form-text">NIK harus 16 digit</div>
                    @error('nik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('nama_lengkap') is-invalid @enderror" 
                           id="nama_lengkap" 
                           name="nama_lengkap" 
                           value="{{ old('nama_lengkap') }}"
                           required>
                    @error('nama_lengkap')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" 
                               class="form-control @error('tempat_lahir') is-invalid @enderror"
                               value="{{ old('tempat_lahir') }}" required>
                        @error('tempat_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" 
                               class="form-control @error('tanggal_lahir') is-invalid @enderror"
                               value="{{ old('tanggal_lahir') }}" required
                               max="{{ date('Y-m-d', strtotime('-17 years')) }}">
                        <div class="form-text">Minimal berusia 17 tahun</div>
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" 
                                class="form-control @error('jenis_kelamin') is-invalid @enderror" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="golongan_darah" class="form-label">Golongan Darah</label>
                        <select name="golongan_darah" id="golongan_darah" 
                                class="form-control @error('golongan_darah') is-invalid @enderror" required>
                            <option value="">Pilih Golongan Darah</option>
                            @foreach(['A', 'B', 'AB', 'O', '-'] as $goldar)
                                <option value="{{ $goldar }}" {{ old('golongan_darah') == $goldar ? 'selected' : '' }}>
                                    {{ $goldar }}
                                </option>
                            @endforeach
                        </select>
                        @error('golongan_darah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="agama" class="form-label">Agama</label>
                        <select name="agama" id="agama" class="form-control @error('agama') is-invalid @enderror" required>
                            <option value="">Pilih Agama</option>
                            @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'] as $agama)
                                <option value="{{ $agama }}" {{ old('agama') == $agama ? 'selected' : '' }}>
                                    {{ $agama }}
                                </option>
                            @endforeach
                        </select>
                        @error('agama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>Alamat</h3>
                
                <div class="form-group">
                    <label for="alamat" class="form-label">Alamat Lengkap</label>
                    <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" 
                              required rows="2">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="rt" class="form-label">RT</label>
                        <input type="text" name="rt" id="rt" class="form-control @error('rt') is-invalid @enderror"
                               value="{{ old('rt') }}" required maxlength="3">
                        @error('rt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-2">
                        <label for="rw" class="form-label">RW</label>
                        <input type="text" name="rw" id="rw" class="form-control @error('rw') is-invalid @enderror"
                               value="{{ old('rw') }}" required maxlength="3">
                        @error('rw')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="kelurahan" class="form-label">Kelurahan/Desa</label>
                        <input type="text" name="kelurahan" id="kelurahan" 
                               class="form-control @error('kelurahan') is-invalid @enderror"
                               value="{{ old('kelurahan') }}" required>
                        @error('kelurahan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="kecamatan" class="form-label">Kecamatan</label>
                        <input type="text" name="kecamatan" id="kecamatan" 
                               class="form-control @error('kecamatan') is-invalid @enderror"
                               value="{{ old('kecamatan') }}" required>
                        @error('kecamatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="kota" class="form-label">Kota/Kabupaten</label>
                        <input type="text" name="kota" id="kota" class="form-control @error('kota') is-invalid @enderror"
                               value="{{ old('kota') }}" required>
                        @error('kota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="provinsi" class="form-label">Provinsi</label>
                        <input type="text" name="provinsi" id="provinsi" 
                               class="form-control @error('provinsi') is-invalid @enderror"
                               value="{{ old('provinsi') }}" required>
                        @error('provinsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="kode_pos" class="form-label">Kode Pos</label>
                        <input type="text" name="kode_pos" id="kode_pos" 
                               class="form-control @error('kode_pos') is-invalid @enderror"
                               value="{{ old('kode_pos') }}" required maxlength="5">
                        @error('kode_pos')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>Informasi Tambahan</h3>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="status_perkawinan" class="form-label">Status Perkawinan</label>
                        <select name="status_perkawinan" id="status_perkawinan" 
                                class="form-control @error('status_perkawinan') is-invalid @enderror" required>
                            <option value="">Pilih Status</option>
                            @foreach(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $status)
                                <option value="{{ $status }}" {{ old('status_perkawinan') == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                        @error('status_perkawinan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="pekerjaan" class="form-label">Pekerjaan</label>
                        <input type="text" name="pekerjaan" id="pekerjaan" 
                               class="form-control @error('pekerjaan') is-invalid @enderror"
                               value="{{ old('pekerjaan') }}" required>
                        @error('pekerjaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="kewarganegaraan" class="form-label">Kewarganegaraan</label>
                        <select name="kewarganegaraan" id="kewarganegaraan" 
                                class="form-control @error('kewarganegaraan') is-invalid @enderror" required>
                            <option value="">Pilih Kewarganegaraan</option>
                            <option value="WNI" {{ old('kewarganegaraan') == 'WNI' ? 'selected' : '' }}>WNI</option>
                            <option value="WNA" {{ old('kewarganegaraan') == 'WNA' ? 'selected' : '' }}>WNA</option>
                        </select>
                        @error('kewarganegaraan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="foto_ktp" class="form-label">Foto KTP <span class="text-danger">*</span></label>
                    <input type="file" 
                           class="form-control @error('foto_ktp') is-invalid @enderror" 
                           id="foto_ktp" 
                           name="foto_ktp"
                           accept="image/*"
                           required>
                    <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                    @error('foto_ktp')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="berlaku_hingga" class="form-label">Berlaku Hingga</label>
                    <input type="date" name="berlaku_hingga" id="berlaku_hingga" 
                           class="form-control @error('berlaku_hingga') is-invalid @enderror"
                           value="{{ old('berlaku_hingga', date('Y-m-d', strtotime('+10 years'))) }}" required>
                    @error('berlaku_hingga')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-control @error('status') is-invalid @enderror" 
                                id="status" 
                                name="status"
                                required>
                            <option value="">Pilih Status</option>
                            <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak aktif" {{ old('status') == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan Data KTP</button>
                <a href="{{ route('admin.ktp.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<style>
.form-section {
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #eee;
}

.form-section h3 {
    color: #2c3e50;
    margin-bottom: 1rem;
    font-size: 1.25rem;
}

.form-row {
    display: flex;
    flex-wrap: wrap;
    margin-right: -10px;
    margin-left: -10px;
}

.form-row > .form-group {
    padding-right: 10px;
    padding-left: 10px;
}

.form-group {
    margin-bottom: 1rem;
}

.col-md-2 { width: 16.666667%; }
.col-md-4 { width: 33.333333%; }
.col-md-6 { width: 50%; }

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #2c3e50;
}

.form-control {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.form-control:focus {
    border-color: #3498db;
    outline: none;
    box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
}

.form-control.is-invalid {
    border-color: #e74c3c;
}

.invalid-feedback {
    color: #e74c3c;
    font-size: 12px;
    margin-top: 0.25rem;
}

.form-text {
    font-size: 12px;
    color: #666;
    margin-top: 0.25rem;
}

.form-actions {
    margin-top: 2rem;
    display: flex;
    gap: 1rem;
}

.btn {
    padding: 0.5rem 1rem;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
    border: none;
}

.btn-primary {
    background: #3498db;
    color: white;
}

.btn-primary:hover {
    background: #2980b9;
}

.btn-secondary {
    background: #95a5a6;
    color: white;
}

.btn-secondary:hover {
    background: #7f8c8d;
}

.alert {
    padding: 1rem;
    border-radius: 4px;
    margin-bottom: 1rem;
}

.alert-danger {
    background: #fee2e2;
    border: 1px solid #ef4444;
    color: #b91c1c;
}

.alert ul {
    margin: 0;
    padding-left: 1rem;
}

@media (max-width: 768px) {
    .col-md-2, .col-md-4, .col-md-6 {
        width: 100%;
    }
    
    .form-row {
        margin-right: 0;
        margin-left: 0;
    }
    
    .form-row > .form-group {
        padding-right: 0;
        padding-left: 0;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validasi NIK hanya angka
    const nikInput = document.getElementById('nik');
    nikInput.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Validasi RT/RW hanya angka
    const rtInput = document.getElementById('rt');
    const rwInput = document.getElementById('rw');
    [rtInput, rwInput].forEach(input => {
        input.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 3) {
                this.value = this.value.slice(0, 3);
            }
        });
    });

    // Validasi Kode Pos hanya angka
    const kodeposInput = document.getElementById('kode_pos');
    kodeposInput.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length > 5) {
            this.value = this.value.slice(0, 5);
        }
    });

    // Preview foto
    const fotoInput = document.getElementById('foto_ktp');
    fotoInput.addEventListener('change', function(e) {
        const file = this.files[0];
        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 2MB');
                this.value = '';
            }
        }
    });
});
</script>
@endsection
