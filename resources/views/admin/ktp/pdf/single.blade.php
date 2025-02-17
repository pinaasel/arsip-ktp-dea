<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Data KTP - {{ $ktp->nama }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h2 {
            margin: 0;
            padding: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
        .content {
            margin-top: 20px;
        }
        .data-row {
            margin-bottom: 10px;
            font-size: 14px;
        }
        .label {
            display: inline-block;
            width: 150px;
            font-weight: bold;
        }
        .value {
            display: inline-block;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>SISTEM INFORMASI ARSIP KTP</h2>
        <p>Jl. Contoh No. 123, Kota Contoh</p>
        <p>Telp: (021) 1234567 | Email: info@arsipktp.com</p>
        <br>
        <h2>DATA KARTU TANDA PENDUDUK</h2>
    </div>

    <div class="content">
        <div class="data-row">
            <span class="label">NIK</span>
            <span class="value">: {{ $ktp->nik }}</span>
        </div>
        <div class="data-row">
            <span class="label">Nama</span>
            <span class="value">: {{ $ktp->nama }}</span>
        </div>
        <div class="data-row">
            <span class="label">Tempat Lahir</span>
            <span class="value">: {{ $ktp->tempat_lahir }}</span>
        </div>
        <div class="data-row">
            <span class="label">Tanggal Lahir</span>
            <span class="value">: {{ $ktp->tanggal_lahir->format('d/m/Y') }}</span>
        </div>
        <div class="data-row">
            <span class="label">Jenis Kelamin</span>
            <span class="value">: {{ $ktp->jenis_kelamin }}</span>
        </div>
        <div class="data-row">
            <span class="label">Alamat</span>
            <span class="value">: {{ $ktp->alamat }}</span>
        </div>
        <div class="data-row">
            <span class="label">RT/RW</span>
            <span class="value">: {{ $ktp->rt }}/{{ $ktp->rw }}</span>
        </div>
        <div class="data-row">
            <span class="label">Kelurahan/Desa</span>
            <span class="value">: {{ $ktp->kelurahan_desa }}</span>
        </div>
        <div class="data-row">
            <span class="label">Kecamatan</span>
            <span class="value">: {{ $ktp->kecamatan }}</span>
        </div>
        <div class="data-row">
            <span class="label">Agama</span>
            <span class="value">: {{ $ktp->agama }}</span>
        </div>
        <div class="data-row">
            <span class="label">Status Perkawinan</span>
            <span class="value">: {{ $ktp->status_perkawinan }}</span>
        </div>
        <div class="data-row">
            <span class="label">Pekerjaan</span>
            <span class="value">: {{ $ktp->pekerjaan }}</span>
        </div>
        <div class="data-row">
            <span class="label">Kewarganegaraan</span>
            <span class="value">: {{ $ktp->kewarganegaraan }}</span>
        </div>
    </div>

    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="signature">
        <p>Mengetahui,</p>
        <p>Kepala Bagian Arsip KTP</p>
        <br><br><br>
        <p>_______________________</p>
        <p>NIP. ........................</p>
    </div>
</body>
</html>
