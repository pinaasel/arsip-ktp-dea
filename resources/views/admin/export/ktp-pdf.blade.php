<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 5px;
        }
        .timestamp {
            text-align: center;
            color: #666;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 12px;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-align: center;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            text-align: right;
            font-style: italic;
            color: #666;
            font-size: 11px;
            margin-top: 20px;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #666;
        }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <div class="timestamp">Tanggal Export: {{ $timestamp }}</div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">NIK</th>
                <th width="20%">Nama Lengkap</th>
                <th width="15%">Tempat Lahir</th>
                <th width="10%">Tanggal Lahir</th>
                <th width="10%">Jenis Kelamin</th>
                <th width="20%">Alamat</th>
                <th width="5%">Status</th>
            </tr>
        </thead>
        <tbody>
            @if($ktps->count() > 0)
                @foreach($ktps as $index => $ktp)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $ktp->nik }}</td>
                        <td>{{ $ktp->nama }}</td>
                        <td>{{ $ktp->tempat_lahir }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($ktp->tanggal_lahir)->format('d/m/Y') }}</td>
                        <td class="text-center">{{ $ktp->jenis_kelamin }}</td>
                        <td>{{ $ktp->alamat }}</td>
                        <td class="text-center">{{ $ktp->status }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="no-data">Tidak ada data</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh: {{ auth()->user()->name }}
    </div>
</body>
</html>
