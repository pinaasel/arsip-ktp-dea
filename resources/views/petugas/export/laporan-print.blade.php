<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .btn {
                display: none !important;
            }
            @page {
                size: landscape;
                margin: 1cm;
            }
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
        .table th {
            background-color: #f8f9fa !important;
        }
    </style>
</head>
<body class="p-4">
    <div class="text-center mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('petugas.export.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print me-2"></i>Export PDF
            </button>
        </div>
        <h4>LAPORAN PENGADUAN KTP</h4>
        <h5>{{ $title }}</h5>
        <p class="mb-0">Petugas: {{ Auth::user()->name }}</p>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>No. Laporan</th>
                <th>NIK</th>
                <th>Nama Lengkap</th>
                <th>Jenis Laporan</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Tanggal Lapor</th>
                <th>Tanggal Update</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $laporan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $laporan->no_laporan }}</td>
                <td>{{ $laporan->ktp->nik }}</td>
                <td>{{ $laporan->ktp->nama_lengkap }}</td>
                <td>{{ $laporan->jenis_laporan }}</td>
                <td>{{ $laporan->keterangan }}</td>
                <td>{{ $laporan->status }}</td>
                <td>{{ $laporan->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $laporan->updated_at->format('d/m/Y H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-5 text-end">
        <p>{{ Auth::user()->name }}</p>
        <p class="mt-5">(.............................)</p>
        <p>Petugas</p>
    </div>

    <script>
        // window.print();
    </script>
</body>
</html>
