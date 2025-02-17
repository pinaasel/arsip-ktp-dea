<!DOCTYPE html>
<html>
<head>
    <title>Data KTP</title>
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
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 12px;
        }
        th {
            background-color: #f5f5f5;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>DATA KTP</h1>
        <p>Total Data: {{ $ktps->count() }}</p>
    </div>

    <div class="content">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Tempat, Tgl Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Agama</th>
                    <th>Status</th>
                    <th>Pekerjaan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ktps as $index => $ktp)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $ktp->nik }}</td>
                    <td>{{ $ktp->nama }}</td>
                    <td>{{ $ktp->tempat_lahir }}, {{ $ktp->tanggal_lahir->format('d/m/Y') }}</td>
                    <td>{{ $ktp->jenis_kelamin }}</td>
                    <td>{{ $ktp->alamat }}</td>
                    <td>{{ $ktp->agama }}</td>
                    <td>{{ $ktp->status_perkawinan }}</td>
                    <td>{{ $ktp->pekerjaan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
