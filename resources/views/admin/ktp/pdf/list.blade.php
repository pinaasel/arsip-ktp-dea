<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }
        table th {
            background-color: #f5f5f5;
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
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
        <h2>{{ $title }}</h2>
        <p>{{ $periode }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">NIK</th>
                <th width="20%">Nama</th>
                <th width="15%">Tempat Lahir</th>
                <th width="10%">Tgl Lahir</th>
                <th width="10%">Gender</th>
                <th width="25%">Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ktps as $index => $ktp)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $ktp->nik }}</td>
                <td>{{ $ktp->nama }}</td>
                <td>{{ $ktp->tempat_lahir }}</td>
                <td>{{ $ktp->tanggal_lahir->format('d/m/Y') }}</td>
                <td>{{ $ktp->jenis_kelamin }}</td>
                <td>{{ $ktp->alamat }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

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
