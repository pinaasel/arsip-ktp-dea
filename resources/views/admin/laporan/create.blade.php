@extends('layouts.app')

@section('title', 'Tambah Laporan')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Laporan</h1>
        <a href="{{ route('admin.laporan.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Laporan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.laporan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="ktp_id">KTP <span class="text-danger">*</span></label>
                    <select name="ktp_id" id="ktp_id" class="form-control select2 @error('ktp_id') is-invalid @enderror" required>
                        <option value="">Pilih KTP</option>
                        @foreach($ktps as $ktp)
                            <option value="{{ $ktp->id }}" {{ old('ktp_id') == $ktp->id ? 'selected' : '' }}>
                                {{ $ktp->nik }} - {{ $ktp->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                    @error('ktp_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jenis_laporan">Jenis Laporan <span class="text-danger">*</span></label>
                    <select name="jenis_laporan" id="jenis_laporan" class="form-control @error('jenis_laporan') is-invalid @enderror" required>
                        <option value="">Pilih Jenis Laporan</option>
                        <option value="kehilangan" {{ old('jenis_laporan') == 'kehilangan' ? 'selected' : '' }}>Kehilangan KTP</option>
                        <option value="kerusakan" {{ old('jenis_laporan') == 'kerusakan' ? 'selected' : '' }}>Kerusakan KTP</option>
                        <option value="perbaikan_data" {{ old('jenis_laporan') == 'perbaikan_data' ? 'selected' : '' }}>Pembaruan Data KTP</option>
                    </select>
                    @error('jenis_laporan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Fields untuk laporan kehilangan --}}
                <div id="kehilangan_fields" style="display: none;">
                    <div class="form-group">
                        <label for="lokasi_kehilangan">Lokasi Kehilangan <span class="text-danger">*</span></label>
                        <input type="text" name="lokasi_kehilangan" id="lokasi_kehilangan" 
                               class="form-control @error('lokasi_kehilangan') is-invalid @enderror" 
                               value="{{ old('lokasi_kehilangan') }}"
                               placeholder="Masukkan lokasi kehilangan KTP">
                        @error('lokasi_kehilangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tanggal_kehilangan">Tanggal Kehilangan <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_kehilangan" id="tanggal_kehilangan" 
                               class="form-control @error('tanggal_kehilangan') is-invalid @enderror" 
                               value="{{ old('tanggal_kehilangan') }}">
                        @error('tanggal_kehilangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Fields untuk laporan kerusakan --}}
                <div id="kerusakan_fields" style="display: none;">
                    <div class="form-group">
                        <label for="detail_kerusakan">Detail Kerusakan <span class="text-danger">*</span></label>
                        <textarea name="detail_kerusakan" id="detail_kerusakan" rows="3" 
                                  class="form-control @error('detail_kerusakan') is-invalid @enderror"
                                  placeholder="Jelaskan detail kerusakan KTP">{{ old('detail_kerusakan') }}</textarea>
                        @error('detail_kerusakan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="foto_kerusakan">Foto Kerusakan <span class="text-danger">*</span></label>
                        <input type="file" name="foto_kerusakan" id="foto_kerusakan" 
                               class="form-control @error('foto_kerusakan') is-invalid @enderror"
                               accept="image/*">
                        <small class="form-text text-muted">Format: jpg, jpeg, png (Max. 2MB)</small>
                        @error('foto_kerusakan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="preview_foto_kerusakan" class="mt-2" style="display: none;">
                            <img id="preview_foto_kerusakan_img" src="" class="img-thumbnail" style="max-height: 200px;">
                        </div>
                    </div>
                </div>

                {{-- Fields untuk laporan pembaruan data --}}
                <div id="perbaikan_data_fields" style="display: none;">
                    <div class="form-group">
                        <label for="alasan_pembaruan">Alasan Pembaruan <span class="text-danger">*</span></label>
                        <textarea name="alasan_pembaruan" id="alasan_pembaruan" rows="3" 
                                  class="form-control @error('alasan_pembaruan') is-invalid @enderror"
                                  placeholder="Jelaskan alasan pembaruan data KTP">{{ old('alasan_pembaruan') }}</textarea>
                        @error('alasan_pembaruan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="foto_pendukung">Foto Dokumen Pendukung <span class="text-danger">*</span></label>
                        <input type="file" name="foto_pendukung" id="foto_pendukung" 
                               class="form-control @error('foto_pendukung') is-invalid @enderror"
                               accept="image/*">
                        <small class="form-text text-muted">Format: jpg, jpeg, png (Max. 2MB)</small>
                        @error('foto_pendukung')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="preview_foto_pendukung" class="mt-2" style="display: none;">
                            <img id="preview_foto_pendukung_img" src="" class="img-thumbnail" style="max-height: 200px;">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="keterangan">Keterangan <span class="text-danger">*</span></label>
                    <textarea name="keterangan" id="keterangan" rows="3" 
                              class="form-control @error('keterangan') is-invalid @enderror"
                              placeholder="Tambahkan keterangan atau informasi tambahan" required>{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <input type="hidden" name="status" value="pending">

                <div class="text-right mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single {
        height: 38px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function() {
        // Inisialisasi Select2
        $('.select2').select2();

        // Fungsi untuk menampilkan/menyembunyikan field berdasarkan jenis laporan
        function toggleFields() {
            var jenisLaporan = $('#jenis_laporan').val();
            
            // Sembunyikan semua field khusus
            $('#kehilangan_fields, #kerusakan_fields, #perbaikan_data_fields').hide();
            
            // Reset required attributes
            $('#lokasi_kehilangan, #tanggal_kehilangan').prop('required', false);
            $('#detail_kerusakan, #foto_kerusakan').prop('required', false);
            $('#alasan_pembaruan, #foto_pendukung').prop('required', false);
            
            // Tampilkan field sesuai jenis laporan yang dipilih
            if (jenisLaporan === 'kehilangan') {
                $('#kehilangan_fields').show();
                $('#lokasi_kehilangan, #tanggal_kehilangan').prop('required', true);
            } else if (jenisLaporan === 'kerusakan') {
                $('#kerusakan_fields').show();
                $('#detail_kerusakan, #foto_kerusakan').prop('required', true);
            } else if (jenisLaporan === 'perbaikan_data') {
                $('#perbaikan_data_fields').show();
                $('#alasan_pembaruan, #foto_pendukung').prop('required', true);
            }
        }

        // Jalankan saat halaman dimuat
        toggleFields();

        // Jalankan saat jenis laporan berubah
        $('#jenis_laporan').change(toggleFields);

        // Preview gambar saat file dipilih
        function readURL(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(previewId).attr('src', e.target.result);
                    $(previewId).parent().show();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Preview untuk foto kerusakan
        $('#foto_kerusakan').change(function() {
            readURL(this, '#preview_foto_kerusakan_img');
        });

        // Preview untuk foto pendukung
        $('#foto_pendukung').change(function() {
            readURL(this, '#preview_foto_pendukung_img');
        });

        // Form validation
        $('form').submit(function(e) {
            var isValid = true;
            var jenisLaporan = $('#jenis_laporan').val();

            // Reset semua pesan error
            $('.invalid-feedback').hide();
            $('.is-invalid').removeClass('is-invalid');

            // Validasi field umum
            if (!$('#ktp_id').val()) {
                $('#ktp_id').addClass('is-invalid');
                isValid = false;
            }

            if (!$('#jenis_laporan').val()) {
                $('#jenis_laporan').addClass('is-invalid');
                isValid = false;
            }

            if (!$('#keterangan').val().trim()) {
                $('#keterangan').addClass('is-invalid');
                isValid = false;
            }

            // Validasi berdasarkan jenis laporan
            if (jenisLaporan === 'kehilangan') {
                if (!$('#lokasi_kehilangan').val().trim()) {
                    $('#lokasi_kehilangan').addClass('is-invalid');
                    isValid = false;
                }
                if (!$('#tanggal_kehilangan').val()) {
                    $('#tanggal_kehilangan').addClass('is-invalid');
                    isValid = false;
                }
            } else if (jenisLaporan === 'kerusakan') {
                if (!$('#detail_kerusakan').val().trim()) {
                    $('#detail_kerusakan').addClass('is-invalid');
                    isValid = false;
                }
                if (!$('#foto_kerusakan').val() && !$('#preview_foto_kerusakan_img').attr('src')) {
                    $('#foto_kerusakan').addClass('is-invalid');
                    isValid = false;
                }
            } else if (jenisLaporan === 'perbaikan_data') {
                if (!$('#alasan_pembaruan').val().trim()) {
                    $('#alasan_pembaruan').addClass('is-invalid');
                    isValid = false;
                }
                if (!$('#foto_pendukung').val() && !$('#preview_foto_pendukung_img').attr('src')) {
                    $('#foto_pendukung').addClass('is-invalid');
                    isValid = false;
                }
            }

            if (!isValid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Mohon lengkapi semua field yang wajib diisi!'
                });
            }
        });
    });
</script>
@endpush