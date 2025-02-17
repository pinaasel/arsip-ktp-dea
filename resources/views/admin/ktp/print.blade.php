<!DOCTYPE html>
<html>
<head>
    <title>KTP - {{ $ktp->nik }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
            width: 200px;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
        }
        .photo-container {
            text-align: center;
            margin: 20px 0;
        }
        .photo {
            max-width: 200px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>DATA KTP</h1>
        <p>NIK: {{ $ktp->nik }}</p>
    </div>

    <div class="content">
        @if($ktp->foto)
        <div class="photo-container">
            <img src="{{ Storage::url($ktp->foto) }}" alt="Foto {{ $ktp->nama }}" class="photo">
        </div>
        @endif

        <table>
            <tr>
                <th>NIK</th>
                <td>{{ $ktp->nik }}</td>
            </tr>
            <tr>
                <th>Nama</th>
                <td>{{ $ktp->nama }}</td>
            </tr>
            <tr>
                <th>Tempat, Tanggal Lahir</th>
                <td>{{ $ktp->tempat_lahir }}, {{ $ktp->tanggal_lahir->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td>{{ $ktp->jenis_kelamin }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $ktp->alamat }}</td>
            </tr>
            <tr>
                <th>RT/RW</th>
                <td>{{ $ktp->rt }}/{{ $ktp->rw }}</td>
            </tr>
            <tr>
                <th>Kelurahan/Desa</th>
                <td>{{ $ktp->kelurahan_desa }}</td>
            </tr>
            <tr>
                <th>Kecamatan</th>
                <td>{{ $ktp->kecamatan }}</td>
            </tr>
            <tr>
                <th>Agama</th>
                <td>{{ $ktp->agama }}</td>
            </tr>
            <tr>
                <th>Status Perkawinan</th>
                <td>{{ $ktp->status_perkawinan }}</td>
            </tr>
            <tr>
                <th>Pekerjaan</th>
                <td>{{ $ktp->pekerjaan }}</td>
            </tr>
            <tr>
                <th>Kewarganegaraan</th>
                <td>{{ $ktp->kewarganegaraan }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
