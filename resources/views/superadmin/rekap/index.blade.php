<x-sidebar-layout>
    <x-slot name="title">Rekap Absensi Bulanan</x-slot>

    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Rekap Absensi Ekstrakurikuler per Bulan</h1>

        <div class="overflow-x-auto bg-white rounded-xl shadow-md border border-gray-200">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Bulan</th>
                        <th class="px-6 py-3 font-semibold">Tahun</th>
                        <th class="px-6 py-3 font-semibold">Nama Eskul</th>
                        <th class="px-6 py-3 font-semibold">Hadir</th>
                        <th class="px-6 py-3 font-semibold">Izin</th>
                        <th class="px-6 py-3 font-semibold">Sakit</th>
                        <th class="px-6 py-3 font-semibold">Alpha</th>
                        <th class="px-6 py-3 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
            <tbody>
                @foreach($rekaps as $r)
                    <tr class="hover:bg-gray-50 text-center">
                        <td class="border px-4 py-2">{{ \App\Helpers\FormatHelper::namaBulan($r->bulan )}}</td>
                        <td class="border px-4 py-2">{{ $r->tahun }}</td>
                        <td class="border px-4 py-2">{{ $r->nama_eskul }}</td>
                        <td class="border px-4 py-2 text-center">{{ $r->total_hadir }}</td>
                        <td class="border px-4 py-2 text-center">{{ $r->total_izin }}</td>
                        <td class="border px-4 py-2 text-center">{{ $r->total_sakit }}</td>
                        <td class="border px-4 py-2 text-center">{{ $r->total_alpha }}</td>
                        <td class="border px-4 py-2 text-center space-x-2">
                            <a href="{{ route('superadmin.rekap.pdf', [ $r->eskul_id,$r->bulan, $r->tahun]) }}" class="text-red-600 hover:underline">PDF</a>
                            <a href="{{ route('superadmin.rekap.excel', [ $r->eskul_id,$r->bulan, $r->tahun]) }}" class="text-green-600 hover:underline">Excel</a>
                            <a href="{{ route('superadmin.rekap.detailExcel', ['eskul_id' => $r->eskul_id, 'bulan' => $r->bulan, 'tahun' => $r->tahun]) }}" class="text-green-600 hover:underline">Detail Excel</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            </div>
        </table>
    </div>
</x-sidebar-layout>
