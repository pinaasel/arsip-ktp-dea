<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail KTP - {{ $ktps->first()->nama_lengkap }}</title>
    <style>
        @media print {
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .detail-container {
                border: 1px solid #000;
                padding: 20px;
                margin: 20px 0;
            }
            .header {
                text-align: center;
                margin-bottom: 30px;
            }
            .logo {
                width: 100px;
                height: auto;
                margin-bottom: 10px;
            }
            .title {
                font-size: 18px;
                font-weight: bold;
                margin: 10px 0;
            }
            .subtitle {
                font-size: 14px;
                color: #666;
            }
            .detail-row {
                display: flex;
                margin-bottom: 15px;
            }
            .detail-label {
                width: 200px;
                font-weight: bold;
            }
            .detail-value {
                flex: 1;
            }
            .photo-container {
                text-align: center;
                margin: 20px 0;
            }
            .ktp-photo {
                max-width: 300px;
                height: auto;
            }
            .footer {
                margin-top: 50px;
                text-align: right;
                font-style: italic;
            }
            .no-print {
                display: none !important;
            }
            .status-badge {
                display: inline-block;
                padding: 5px 10px;
                border-radius: 4px;
                font-weight: bold;
            }
            .status-aktif {
                background-color: #4caf50 !important;
                color: white;
            }
            .status-nonaktif {
                background-color: #f44336 !important;
                color: white;
            }
        }

        /* Screen styles */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .detail-container {
            border: 1px solid #000;
            padding: 20px;
            margin: 20px 0;
            max-width: 800px;
            margin: 20px auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            width: 100px;
            height: auto;
            margin-bottom: 10px;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0;
        }
        .subtitle {
            font-size: 14px;
            color: #666;
        }
        .detail-row {
            display: flex;
            margin-bottom: 15px;
        }
        .detail-label {
            width: 200px;
            font-weight: bold;
        }
        .detail-value {
            flex: 1;
        }
        .photo-container {
            text-align: center;
            margin: 20px 0;
        }
        .ktp-photo {
            max-width: 300px;
            height: auto;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
            font-style: italic;
        }
        .button-container {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
        }
        .btn-print {
            background-color: #007bff;
            color: white;
        }
        .btn-back {
            background-color: #6c757d;
            color: white;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
        }
        .status-aktif {
            background-color: #4caf50;
            color: white;
        }
        .status-nonaktif {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>
    <div class="button-container no-print">
        <button onclick="window.print()" class="btn btn-print">Print PDF</button>
        <a href="{{ route('admin.ktp.show', $ktps->first()->id) }}" class="btn btn-back">Kembali</a>
    </div>

    <div class="detail-container">
        <div class="header">
            <div class="title">DETAIL KARTU TANDA PENDUDUK</div>
            <div class="subtitle">{{ $timestamp }}</div>
        </div>

        @if($ktps->count() > 0)
            @php $ktp = $ktps->first(); @endphp
            
            <div class="photo-container">
                @if($ktp->foto_ktp)
                    <img src="{{ asset('storage/' . $ktp->foto_ktp) }}" alt="Foto KTP" class="ktp-photo">
                @else
                    <div style="color: #666;">Foto KTP tidak tersedia</div>
                @endif
            </div>

            <div class="detail-row">
                <div class="detail-label">Status KTP</div>
                <div class="detail-value">
                    <span class="status-badge status-{{ $ktp->status }}">
                        {{ ucfirst($ktp->status) }}
                    </span>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">NIK</div>
                <div class="detail-value">{{ $ktp->nik }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Nama Lengkap</div>
                <div class="detail-value">{{ $ktp->nama_lengkap }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Tempat, Tanggal Lahir</div>
                <div class="detail-value">
                    {{ $ktp->tempat_lahir }}, {{ \Carbon\Carbon::parse($ktp->tanggal_lahir)->format('d F Y') }}
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Jenis Kelamin</div>
                <div class="detail-value">{{ $ktp->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Golongan Darah</div>
                <div class="detail-value">{{ $ktp->golongan_darah }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Alamat</div>
                <div class="detail-value">{{ $ktp->alamat }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">RT/RW</div>
                <div class="detail-value">{{ $ktp->rt_rw }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Kelurahan/Desa</div>
                <div class="detail-value">{{ $ktp->kel_desa }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Kecamatan</div>
                <div class="detail-value">{{ $ktp->kecamatan }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Kota/Kabupaten</div>
                <div class="detail-value">{{ $ktp->kota }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Provinsi</div>
                <div class="detail-value">{{ $ktp->provinsi }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Agama</div>
                <div class="detail-value">{{ $ktp->agama }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Status Perkawinan</div>
                <div class="detail-value">{{ $ktp->status_perkawinan }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Pekerjaan</div>
                <div class="detail-value">{{ $ktp->pekerjaan }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Kewarganegaraan</div>
                <div class="detail-value">{{ $ktp->kewarganegaraan }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Berlaku Hingga</div>
                <div class="detail-value">{{ \Carbon\Carbon::parse($ktp->berlaku_hingga)->format('d F Y') }}</div>
            </div>

            <div class="footer">
                Dicetak oleh: {{ auth()->user()->name }}<br>
                Tanggal: {{ $timestamp }}
            </div>
        @else
            <div style="text-align: center; color: #666;">Data KTP tidak ditemukan</div>
        @endif
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
