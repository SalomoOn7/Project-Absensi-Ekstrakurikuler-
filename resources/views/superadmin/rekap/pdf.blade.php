<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekap Absensi</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 20px; }
        h2, h3 { text-align: center; margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; font-size: 13px; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
        .footer { margin-top: 50px; text-align: right; }
    </style>
</head>
<body>

    <div class="header">
        <h2>SMK TI Pembangunan Cimahi</h2>
        <h3>Laporan Rekapitulasi Absensi Ekstrakurikuler</h3>
        <p>Bulan: {{ $bulanNama }} - Tahun: {{ $tahun }}</p>
        <hr>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nama Eskul</th>
                <th>Total Hadir</th>
                <th>Total Izin</th>
                <th>Total Sakit</th>
                <th>Total Alpha</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $rekaps->nama_eskul }}</td>
                <td>{{ $rekaps->total_hadir }}</td>
                <td>{{ $rekaps->total_izin }}</td>
                <td>{{ $rekaps->total_sakit }}</td>
                <td>{{ $rekaps->total_alpha }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p><strong>Mengetahui,</strong><br>Pembina Ekstrakurikuler</p>
        <br><br><br>
        <p><strong>_________________________</strong></p>
    </div>

</body>
</html>
