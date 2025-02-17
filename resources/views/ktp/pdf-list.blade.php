<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
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
            font-size: 12px;
        }
        .data-table th, .data-table td {
            padding: 6px;
            border: 1px solid #ddd;
        }
        .data-table th {
            background-color: #f4f4f4;
            font-weight: bold;
            text-align: left;
        }
        .periode {
            margin-bottom: 20px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $title }}</h2>
        <p class="periode">{{ $periode }}</p>
    </div>

    <table class="data-table">
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
                <th>Berlaku Hingga</th>
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
                <td>
                    {{ $ktp->alamat }},
                    RT {{ $ktp->rt }}/RW {{ $ktp->rw }},
                    {{ $ktp->kelurahan }}, {{ $ktp->kecamatan }}
                </td>
                <td>{{ $ktp->agama }}</td>
                <td>{{ $ktp->status_perkawinan }}</td>
                <td>{{ $ktp->pekerjaan }}</td>
                <td>{{ $ktp->berlaku_hingga->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px;">
        <p>Total Data: {{ $ktps->count() }} KTP</p>
    </div>
</body>
</html>
