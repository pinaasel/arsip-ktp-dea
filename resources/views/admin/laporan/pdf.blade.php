<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan KTP - {{ $laporan->ktp->nama_lengkap }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .info-table td:first-child {
            width: 30%;
            font-weight: bold;
        }
        .image-container {
            margin-top: 20px;
        }
        .image-container img {
            max-width: 300px;
            height: auto;
        }
        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <h1>Detail Laporan KTP</h1>

    <table class="info-table">
        <!-- Data KTP -->
        <tr>
            <td>NIK</td>
            <td>: {{ $laporan->ktp->nik }}</td>
        </tr>
        <tr>
            <td>Nama Lengkap</td>
            <td>: {{ $laporan->ktp->nama_lengkap }}</td>
        </tr>
        
        <!-- Data Laporan -->
        <tr>
            <td>Jenis Laporan</td>
            <td>: {{ ucfirst($laporan->jenis_laporan) }}</td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>: {{ $laporan->keterangan }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>: {{ ucfirst($laporan->status) }}</td>
        </tr>
        
        <!-- Data spesifik berdasarkan jenis laporan -->
        @if($laporan->jenis_laporan == 'kehilangan')
            <tr>
                <td>Lokasi Kehilangan</td>
                <td>: {{ $laporan->lokasi_kehilangan }}</td>
            </tr>
            <tr>
                <td>Tanggal Kehilangan</td>
                <td>: {{ $laporan->tanggal_kehilangan ? $laporan->tanggal_kehilangan->format('d/m/Y') : '-' }}</td>
            </tr>
        @elseif($laporan->jenis_laporan == 'kerusakan')
            <tr>
                <td>Detail Kerusakan</td>
                <td>: {{ $laporan->detail_kerusakan }}</td>
            </tr>
            @if($laporan->foto_kerusakan)
                <tr>
                    <td>Foto Kerusakan</td>
                    <td>
                        <div class="image-container">
                            <img src="{{ asset('storage/' . $laporan->foto_kerusakan) }}" alt="Foto Kerusakan">
                        </div>
                    </td>
                </tr>
            @endif
        @elseif($laporan->jenis_laporan == 'perbaikan_data')
            <tr>
                <td>Alasan Pembaruan</td>
                <td>: {{ $laporan->alasan_pembaruan }}</td>
            </tr>
            @if($laporan->foto_pendukung)
                <tr>
                    <td>Foto Pendukung</td>
                    <td>
                        <div class="image-container">
                            <img src="{{ asset('storage/' . $laporan->foto_pendukung) }}" alt="Foto Pendukung">
                        </div>
                    </td>
                </tr>
            @endif
        @endif
    </table>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
