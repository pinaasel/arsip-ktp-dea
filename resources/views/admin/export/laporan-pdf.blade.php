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
    <div class="timestamp">Tanggal Export: {{ now()->format('d/m/Y H:i') }}</div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="10%">Tanggal</th>
                <th width="15%">NIK</th>
                <th width="15%">Nama</th>
                <th width="10%">Jenis</th>
                <th width="25%">Keterangan</th>
                <th width="10%">Status</th>
                <th width="10%">Petugas</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporans as $index => $laporan)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $laporan->created_at->format('d/m/Y') }}</td>
                    <td>{{ $laporan->ktp->nik }}</td>
                    <td>{{ $laporan->ktp->nama_lengkap }}</td>
                    <td class="text-center">{{ ucfirst($laporan->jenis_laporan) }}</td>
                    <td>
                        {{ $laporan->keterangan }}
                        @if($laporan->jenis_laporan == 'kehilangan')
                            <div class="detail-info">
                                Lokasi: {{ $laporan->lokasi_kehilangan }}<br>
                                Tanggal: {{ $laporan->tanggal_kehilangan ? $laporan->tanggal_kehilangan->format('d/m/Y') : '-' }}
                            </div>
                        @elseif($laporan->jenis_laporan == 'kerusakan')
                            <div class="detail-info">
                                Detail: {{ $laporan->detail_kerusakan }}
                            </div>
                        @elseif($laporan->jenis_laporan == 'perbaikan_data')
                            <div class="detail-info">
                                Alasan: {{ $laporan->alasan_pembaruan }}
                            </div>
                        @endif
                    </td>
                    <td>{{ ucfirst($laporan->status) }}</td>
                    <td>{{ $laporan->petugas->name }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="no-data">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh: {{ auth()->user()->name }}
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
