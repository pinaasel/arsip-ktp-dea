<!DOCTYPE html>
<html>
<head>
    <title>Daftar KTP</title>
    <style>
        @media print {
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                margin: 20px;
                -webkit-print-color-adjust: exact;
            }
            .header {
                text-align: center;
                margin-bottom: 30px;
                border-bottom: 2px solid #333;
                padding-bottom: 20px;
            }
            .header h1 {
                margin: 0;
                font-size: 24px;
            }
            .header p {
                margin: 5px 0;
                font-size: 14px;
                color: #666;
            }
            .content {
                margin-bottom: 20px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
                page-break-inside: auto;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            th, td {
                padding: 10px;
                border: 1px solid #ddd;
                text-align: left;
                font-size: 12px;
            }
            th {
                background-color: #f5f5f5 !important;
                font-weight: bold;
            }
            .footer {
                position: fixed;
                bottom: 0;
                width: 100%;
                text-align: right;
                font-size: 12px;
                padding: 10px 0;
                border-top: 1px solid #ddd;
            }
            .print-button {
                display: none;
            }
            .page-break {
                page-break-after: always;
            }
        }
        
        /* Styles for screen display */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
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
            font-size: 12px;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
            font-size: 12px;
            padding: 10px 0;
            border-top: 1px solid #ddd;
        }
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .print-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-button">Cetak Daftar KTP</button>
    
    <div class="header">
        <h1>DAFTAR DATA KTP</h1>
        <p>
            @if($period === 'daily')
                Periode: {{ Carbon\Carbon::parse($date)->format('d F Y') }}
            @elseif($period === 'monthly')
                Periode: {{ Carbon\Carbon::parse($date)->format('F Y') }}
            @elseif($period === 'yearly')
                Periode: Tahun {{ $date }}
            @else
                Semua Data
            @endif
        </p>
        @if($status !== 'all')
            <p>Status: {{ ucfirst($status) }}</p>
        @endif
        <p>Total Data: {{ $ktps->count() }} KTP</p>
    </div>

    <div class="content">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>NIK</th>
                    <th>Nama Lengkap</th>
                    <th>Tempat, Tgl Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>RT/RW</th>
                    <th>Kel/Desa</th>
                    <th>Kecamatan</th>
                    <th>Status</th>
                    <th>Berlaku Hingga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ktps as $index => $ktp)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $ktp->nik }}</td>
                    <td>{{ $ktp->nama_lengkap }}</td>
                    <td>{{ $ktp->tempat_lahir }}, {{ Carbon\Carbon::parse($ktp->tanggal_lahir)->format('d/m/Y') }}</td>
                    <td>{{ $ktp->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td>{{ $ktp->alamat }}</td>
                    <td>{{ $ktp->rt_rw }}</td>
                    <td>{{ $ktp->kel_desa }}</td>
                    <td>{{ $ktp->kecamatan }}</td>
                    <td>{{ ucfirst($ktp->status) }}</td>
                    <td>{{ Carbon\Carbon::parse($ktp->berlaku_hingga)->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>Oleh: {{ auth()->user()->name }}</p>
    </div>
</body>
</html>
