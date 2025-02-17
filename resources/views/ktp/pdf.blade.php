<!DOCTYPE html>
<html>
<head>
    <title>Data KTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .data-table th, .data-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .data-table th {
            background-color: #f4f4f4;
            font-weight: bold;
            text-align: left;
        }
        .foto {
            max-width: 150px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Data Kartu Tanda Penduduk (KTP)</h2>
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <table class="data-table">
        <tr>
            <th width="30%">NIK</th>
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
            <td>
                {{ $ktp->alamat }}<br>
                RT {{ $ktp->rt }} / RW {{ $ktp->rw }}<br>
                Kel. {{ $ktp->kelurahan }}, Kec. {{ $ktp->kecamatan }}<br>
                {{ $ktp->kota }}, {{ $ktp->provinsi }} {{ $ktp->kode_pos }}
            </td>
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
        <tr>
            <th>Golongan Darah</th>
            <td>{{ $ktp->golongan_darah }}</td>
        </tr>
        <tr>
            <th>Berlaku Hingga</th>
            <td>{{ $ktp->berlaku_hingga->format('d/m/Y') }}</td>
        </tr>
    </table>

    @if($ktp->foto)
    <div style="margin-top: 20px;">
        <strong>Foto KTP:</strong><br>
        <img src="{{ public_path('storage/'.$ktp->foto) }}" class="foto">
    </div>
    @endif
</body>
</html>
