<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan KTP - {{ $laporan->ktp->nik }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background: #f8f9fa;
        }
        .container {
            max-width: 1000px;
            margin: 20px auto;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 40px;
            border-radius: 8px;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e9ecef;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #2c3e50;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
            color: #6c757d;
        }
        .section {
            margin-bottom: 40px;
        }
        .section h2 {
            font-size: 18px;
            color: #2c3e50;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-weight: 600;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: white;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
            font-size: 14px;
        }
        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
        }
        tr:hover {
            background-color: #f8f9fa;
        }
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .badge-danger { 
            background-color: #fee2e2; 
            color: #dc2626;
        }
        .badge-warning { 
            background-color: #fef3c7; 
            color: #d97706;
        }
        .badge-success { 
            background-color: #dcfce7; 
            color: #16a34a;
        }
        .signature {
            margin-top: 60px;
            text-align: right;
            color: #2c3e50;
        }
        .signature p {
            margin: 5px 0;
        }
        .signature .date {
            color: #6c757d;
            font-size: 14px;
        }
        .signature .name {
            font-size: 16px;
            font-weight: 600;
        }
        .signature .title {
            color: #6c757d;
            font-size: 14px;
        }
        .button-group {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
        }
        .button {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .button-primary {
            background: #3b82f6;
            color: white;
        }
        .button-primary:hover {
            background: #2563eb;
        }
        .button-secondary {
            background: #6b7280;
            color: white;
        }
        .button-secondary:hover {
            background: #4b5563;
        }
        @media print {
            body {
                background: white;
            }
            .container {
                margin: 0;
                padding: 40px;
                box-shadow: none;
            }
            .no-print {
                display: none;
            }
            .page-break {
                page-break-after: always;
            }
            table {
                page-break-inside: auto;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
    </style>
</head>
<body>
    <div class="button-group no-print">
        <button class="button button-secondary" onclick="window.history.back()">
            ← Kembali
        </button>
        <button class="button button-primary" onclick="window.print()">
            Print Laporan
        </button>
    </div>

    <div class="container">
        <div class="header">
            <h1>Laporan Pengajuan KTP</h1>
            <p>Dinas Kependudukan dan Pencatatan Sipil</p>
            <p>Kabupaten/Kota</p>
        </div>

        <div class="section">
            <h2>Informasi Laporan</h2>
            <table>
                <tr>
                    <th style="width: 200px">Status</th>
                    <td>
                        <span class="badge badge-{{ $laporan->status == 'pending' ? 'danger' : ($laporan->status == 'diproses' ? 'warning' : 'success') }}">
                            {{ ucfirst($laporan->status) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Jenis Laporan</th>
                    <td>{{ $laporan->jenis_laporan_label }}</td>
                </tr>
                <tr>
                    <th>Tanggal Laporan</th>
                    <td>{{ $laporan->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Petugas</th>
                    <td>{{ $laporan->petugas->name }}</td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td>{{ $laporan->keterangan }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h2>Data KTP</h2>
            <table>
                <tr>
                    <th style="width: 200px">NIK</th>
                    <td>{{ $laporan->ktp->nik }}</td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <td>{{ $laporan->ktp->nama }}</td>
                </tr>
                <tr>
                    <th>Tempat, Tanggal Lahir</th>
                    <td>{{ $laporan->ktp->tempat_lahir }}, {{ $laporan->ktp->tanggal_lahir->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Jenis Kelamin</th>
                    <td>{{ $laporan->ktp->jenis_kelamin }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $laporan->ktp->alamat }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h2>Detail Pengajuan</h2>
            <table>
                @if($laporan->jenis_laporan == 'kehilangan')
                <tr>
                    <th style="width: 200px">Lokasi Kehilangan</th>
                    <td>{{ $laporan->lokasi_kehilangan }}</td>
                </tr>
                <tr>
                    <th>Tanggal Kehilangan</th>
                    <td>{{ $laporan->tanggal_kehilangan->format('d/m/Y') }}</td>
                </tr>
                @elseif($laporan->jenis_laporan == 'kerusakan')
                <tr>
                    <th style="width: 200px">Detail Kerusakan</th>
                    <td>{{ $laporan->detail_kerusakan }}</td>
                </tr>
                @else
                <tr>
                    <th style="width: 200px">Alasan Pembaruan</th>
                    <td>{{ $laporan->alasan_pembaruan }}</td>
                </tr>
                @endif
            </table>
        </div>

        <div class="section">
            <h2>Riwayat Status</h2>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th>Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laporan->riwayatStatus as $riwayat)
                    <tr>
                        <td>{{ $riwayat->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <span class="badge badge-{{ $riwayat->status == 'pending' ? 'danger' : ($riwayat->status == 'diproses' ? 'warning' : 'success') }}">
                                {{ ucfirst($riwayat->status) }}
                            </span>
                        </td>
                        <td>{{ $riwayat->catatan }}</td>
                        <td>{{ $riwayat->petugas->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="signature">
            <p class="date">{{ now()->format('d/m/Y H:i') }}</p>
            <br><br><br>
            <p class="name">{{ auth()->user()->name }}</p>
            <p class="title">Petugas</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            // Auto print when page loads
            window.print();
        }
    </script>
</body>
</html>
