<table>
    <thead>
        <tr>
            <th>Nama Eskul</th>
            <th>Bulan</th>
            <th>Tahun</th>
            <th>Total Hadir</th>
            <th>Total Izin</th>
            <th>Total Sakit</th>
            <th>Total Alpha</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rekaps as $r)
        <tr>
            <td>{{ $r->nama_eskul }}</td>
            <td>{{ $r->bulan }}</td>
            <td>{{ $r->tahun }}</td>
            <td>{{ $r->total_hadir }}</td>
            <td>{{ $r->total_izin }}</td>
            <td>{{ $r->total_sakit }}</td>
            <td>{{ $r->total_alpha }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
