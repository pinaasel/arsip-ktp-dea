<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        @media print {
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
            }
            th, td {
                border: 1px solid #000;
                padding: 8px;
                font-size: 12px;
            }
            th {
                background-color: #f5f5f5 !important;
                font-weight: bold;
                text-align: center;
            }
            h1 {
                text-align: center;
                font-size: 18px;
                margin-bottom: 5px;
            }
            .timestamp {
                text-align: center;
                color: #666;
                margin-bottom: 20px;
            }
            .text-center {
                text-align: center;
            }
            .footer {
                position: fixed;
                bottom: 20px;
                right: 20px;
                font-style: italic;
                font-size: 11px;
            }
            .no-print {
                display: none;
            }
        }

        /* Styles for screen display */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #fff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 12px;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-align: center;
        }
        h1 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 5px;
        }
        .timestamp {
            text-align: center;
            color: #666;
            margin-bottom: 20px;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            text-align: right;
            font-style: italic;
            font-size: 11px;
            margin-top: 20px;
        }
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .print-button:hover {
            background: #0056b3;
        }
        @media screen {
            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <button onclick="window.print()" class="print-button no-print">Print PDF</button>
        
        <h1>{{ $title }}</h1>
        <div class="timestamp">Tanggal Export: {{ $timestamp }}</div>

        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">No Laporan</th>
                    <th width="15%">NIK</th>
                    <th width="20%">Nama</th>
                    <th width="15%">Jenis Laporan</th>
                    <th width="15%">Petugas</th>
                    <th width="15%">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @if($laporans->count() > 0)
                    @foreach($laporans as $index => $laporan)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $laporan->no_laporan }}</td>
                            <td>{{ $laporan->ktp->nik }}</td>
                            <td>{{ $laporan->ktp->nama }}</td>
                            <td class="text-center">{{ ucfirst($laporan->jenis_laporan) }}</td>
                            <td>{{ $laporan->petugas->name }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($laporan->created_at)->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div class="footer">
            Dicetak oleh: {{ auth()->user()->name }}
        </div>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
