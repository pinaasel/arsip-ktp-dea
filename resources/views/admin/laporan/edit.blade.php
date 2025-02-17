@extends('layouts.app')

@section('title', 'Edit Laporan')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Laporan</h1>
        <a href="{{ route('admin.laporan.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="ktp_id">KTP</label>
                    <select name="ktp_id" id="ktp_id" class="form-control @error('ktp_id') is-invalid @enderror" required>
                        <option value="">Pilih KTP</option>
                        @foreach($ktps as $ktp)
                            <option value="{{ $ktp->id }}" {{ $laporan->ktp_id == $ktp->id ? 'selected' : '' }}>
                                {{ $ktp->nik }} - {{ $ktp->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                    @error('ktp_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="petugas_id">Petugas <span class="text-danger">*</span></label>
                    <select name="petugas_id" id="petugas_id" class="form-control select2 @error('petugas_id') is-invalid @enderror">
                        <option value="">Pilih Petugas</option>
                        @foreach($petugas as $p)
                            <option value="{{ $p->id }}" {{ old('petugas_id', $laporan->petugas_id) == $p->id ? 'selected' : '' }}>
                                {{ $p->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('petugas_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jenis_laporan">Jenis Laporan</label>
                    <select name="jenis_laporan" id="jenis_laporan" class="form-control @error('jenis_laporan') is-invalid @enderror" required>
                        <option value="">Pilih Jenis Laporan</option>
                        <option value="kehilangan" {{ $laporan->jenis_laporan == 'kehilangan' ? 'selected' : '' }}>Kehilangan</option>
                        <option value="kerusakan" {{ $laporan->jenis_laporan == 'kerusakan' ? 'selected' : '' }}>Kerusakan</option>
                        <option value="perbaikan_data" {{ $laporan->jenis_laporan == 'perbaikan_data' ? 'selected' : '' }}>Perbaikan Data</option>
                    </select>
                    @error('jenis_laporan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="keterangan">Keterangan <span class="text-danger">*</span></label>
                    <textarea name="keterangan" id="keterangan" rows="4" 
                              class="form-control @error('keterangan') is-invalid @enderror"
                              placeholder="Masukkan keterangan">{{ old('keterangan', $laporan->keterangan) }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Form Kehilangan -->
                <div id="form-kehilangan" class="dynamic-form" style="display: none;">
                    <div class="form-group">
                        <label for="lokasi_kehilangan">Lokasi Kehilangan <span class="text-danger">*</span></label>
                        <input type="text" name="lokasi_kehilangan" id="lokasi_kehilangan" 
                               class="form-control @error('lokasi_kehilangan') is-invalid @enderror"
                               value="{{ old('lokasi_kehilangan', $laporan->lokasi_kehilangan) }}"
                               placeholder="Masukkan lokasi kehilangan">
                        @error('lokasi_kehilangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tanggal_kehilangan">Tanggal Kehilangan <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_kehilangan" id="tanggal_kehilangan" 
                               class="form-control @error('tanggal_kehilangan') is-invalid @enderror"
                               value="{{ old('tanggal_kehilangan', $laporan->tanggal_kehilangan ? $laporan->tanggal_kehilangan->format('Y-m-d') : '') }}">
                        @error('tanggal_kehilangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Form Kerusakan -->
                <div id="form-kerusakan" class="dynamic-form" style="display: none;">
                    <div class="form-group">
                        <label for="detail_kerusakan">Detail Kerusakan <span class="text-danger">*</span></label>
                        <textarea name="detail_kerusakan" id="detail_kerusakan" rows="3" 
                                  class="form-control @error('detail_kerusakan') is-invalid @enderror"
                                  placeholder="Jelaskan detail kerusakan">{{ old('detail_kerusakan', $laporan->detail_kerusakan) }}</textarea>
                        @error('detail_kerusakan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="foto_kerusakan">Foto Kerusakan</label>
                        @if($laporan->foto_kerusakan)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $laporan->foto_kerusakan) }}" alt="Foto Kerusakan" class="img-thumbnail" style="max-height: 200px;">
                                <p class="text-muted mt-1">Foto kerusakan saat ini</p>
                            </div>
                        @endif
                        <input type="file" name="foto_kerusakan" id="foto_kerusakan" 
                               class="form-control-file @error('foto_kerusakan') is-invalid @enderror"
                               accept="image/*">
                        <small class="form-text text-muted">Upload foto baru jika ingin mengubah foto yang ada</small>
                        @error('foto_kerusakan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Form Perbaikan Data -->
                <div id="form-perbaikan_data" class="dynamic-form" style="display: none;">
                    <div class="form-group">
                        <label for="alasan_pembaruan">Alasan Pembaruan <span class="text-danger">*</span></label>
                        <textarea name="alasan_pembaruan" id="alasan_pembaruan" rows="3" 
                                  class="form-control @error('alasan_pembaruan') is-invalid @enderror"
                                  placeholder="Jelaskan alasan pembaruan data">{{ old('alasan_pembaruan', $laporan->alasan_pembaruan) }}</textarea>
                        @error('alasan_pembaruan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="foto_pendukung">Foto Pendukung</label>
                        @if($laporan->foto_pendukung)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $laporan->foto_pendukung) }}" alt="Foto Pendukung" class="img-thumbnail" style="max-height: 200px;">
                                <p class="text-muted mt-1">Foto pendukung saat ini</p>
                            </div>
                        @endif
                        <input type="file" name="foto_pendukung" id="foto_pendukung" 
                               class="form-control-file @error('foto_pendukung') is-invalid @enderror"
                               accept="image/*">
                        <small class="form-text text-muted">Upload foto baru jika ingin mengubah foto yang ada</small>
                        @error('foto_pendukung')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="">Pilih Status</option>
                        <option value="pending" {{ $laporan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diproses" {{ $laporan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ $laporan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize select2
    $('#ktp_id').select2({
        placeholder: 'Pilih KTP',
        allowClear: true
    });

    $('#petugas_id').select2({
        placeholder: 'Pilih Petugas',
        allowClear: true
    });

    // Show/hide dynamic forms based on jenis_laporan
    function toggleDynamicForms() {
        var selectedType = $('#jenis_laporan').val();
        $('.dynamic-form').hide();
        
        if (selectedType) {
            $('#form-' + selectedType).show();
            
            // Set required fields based on form type
            if (selectedType === 'kehilangan') {
                $('#lokasi_kehilangan, #tanggal_kehilangan').prop('required', true);
                $('#detail_kerusakan, #alasan_pembaruan').prop('required', false);
            } else if (selectedType === 'kerusakan') {
                $('#detail_kerusakan').prop('required', true);
                $('#lokasi_kehilangan, #tanggal_kehilangan, #alasan_pembaruan').prop('required', false);
            } else if (selectedType === 'perbaikan_data') {
                $('#alasan_pembaruan').prop('required', true);
                $('#lokasi_kehilangan, #tanggal_kehilangan, #detail_kerusakan').prop('required', false);
            }
        }
    }

    // On change
    $('#jenis_laporan').change(function() {
        toggleDynamicForms();
    });

    // Initial form display
    toggleDynamicForms();

    // Image preview for new uploads
    function readURL(input, previewSelector) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = $(previewSelector);
                if (preview.length === 0) {
                    // Create new preview
                    var container = $('<div class="mb-2">').insertBefore(input);
                    $('<img>').attr({
                        'src': e.target.result,
                        'class': 'img-thumbnail',
                        'style': 'max-height: 200px;'
                    }).appendTo(container);
                } else {
                    // Update existing preview
                    preview.find('img').attr('src', e.target.result);
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Setup image preview handlers
    $('#foto_kerusakan').change(function() {
        readURL(this, '#form-kerusakan .mb-2');
    });

    $('#foto_pendukung').change(function() {
        readURL(this, '#form-perbaikan_data .mb-2');
    });
});
</script>
@endpush
