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
        <h4>LAPORAN DATA KTP</h4>
        <h5>{{ $title }}</h5>
        <p class="mb-0">Petugas: {{ Auth::user()->name }}</p>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>NIK</th>
                <th>Nama Lengkap</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>RT/RW</th>
                <th>Kel/Desa</th>
                <th>Kecamatan</th>
                <th>Agama</th>
                <th>Status Perkawinan</th>
                <th>Pekerjaan</th>
                <th>Kewarganegaraan</th>
                <th>Berlaku Hingga</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $ktp)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $ktp->nik }}</td>
                <td>{{ $ktp->nama_lengkap }}</td>
                <td>{{ $ktp->tempat_lahir }}</td>
                <td>{{ $ktp->tanggal_lahir->format('d/m/Y') }}</td>
                <td>{{ $ktp->jenis_kelamin }}</td>
                <td>{{ $ktp->alamat }}</td>
                <td>{{ $ktp->rt_rw }}</td>
                <td>{{ $ktp->kel_desa }}</td>
                <td>{{ $ktp->kecamatan }}</td>
                <td>{{ $ktp->agama }}</td>
                <td>{{ $ktp->status_perkawinan }}</td>
                <td>{{ $ktp->pekerjaan }}</td>
                <td>{{ $ktp->kewarganegaraan }}</td>
                <td>{{ $ktp->berlaku_hingga->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="15" class="text-center">Tidak ada data</td>
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
        // window.onload = function() {
        //     window.print();
        // }
    </script>
</body>
</html>
