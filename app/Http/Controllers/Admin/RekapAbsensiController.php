<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Absensi;
use App\Models\Anggota;
use App\Models\RekapBulanan;
use App\Exports\RekapDetailExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapExport;

class RekapAbsensiController extends Controller
{
    public function index(Request $request){

        $eskulId = Auth::user()->eskul_id;
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));

        // Ambil semua anggota dari eskul ini
        $anggotaList = Anggota::where('eskul_id', $eskulId)->get();

        // Ambil data rekap dari absensi
        $rekap = Absensi::select(
                'anggota_id',
                DB::raw("SUM(status = 'Hadir') as total_hadir"),
                DB::raw("SUM(status = 'Izin') as total_izin"),
                DB::raw("SUM(status = 'Sakit') as total_sakit"),
                DB::raw("SUM(status = 'Alpha') as total_alpha")
            )
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->whereIn('anggota_id', $anggotaList->pluck('anggota_id'))
            ->groupBy('anggota_id')
            ->get()
            ->keyBy('anggota_id');

        return view('admin.rekap.index', compact('anggotaList', 'rekap', 'bulan', 'tahun'));
    }


    public function store(Request $request)
{
    $eskulId = Auth::user()->eskul_id;
    $bulan = $request->bulan;
    $tahun = $request->tahun;

    // 🔎 Cek apakah rekap bulan ini sudah ada
    $rekapSudahAda = DB::table('rekap_bulanan')
        ->where('eskul_id', $eskulId)
        ->where('bulan', $bulan)
        ->where('tahun', $tahun)
        ->exists();

    if ($rekapSudahAda) {
        // ⚠️ Jika sudah ada, tampilkan pesan dan hentikan proses
        return redirect()->route('admin.rekap.index', [
            'bulan' => $bulan,
            'tahun' => $tahun,
        ])->with('warning', 'Rekap absensi bulan ini sudah diisi sebelumnya.');
    }

    // 🔁 Jika belum ada, lanjut buat rekap
    $anggotaList = Anggota::where('eskul_id', $eskulId)->get();

    foreach ($anggotaList as $a) {
        $data = DB::table('absensis')
            ->where('anggota_id', $a->anggota_id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->selectRaw("
                SUM(status = 'Hadir') as hadir,
                SUM(status = 'Izin') as izin,
                SUM(status = 'Sakit') as sakit,
                SUM(status = 'Alpha') as alpha
            ")
            ->first();

        DB::table('rekap_bulanan')->updateOrInsert(
            [
                'anggota_id' => $a->anggota_id,
                'eskul_id' => $eskulId,
                'bulan' => $bulan,
                'tahun' => $tahun,
            ],
            [
                'total_hadir' => $data->hadir ?? 0,
                'total_izin' => $data->izin ?? 0,
                'total_sakit' => $data->sakit ?? 0,
                'total_alpha' => $data->alpha ?? 0,
                'dibuat_oleh' => Auth::user()->user_id,
                'dibuat_pada' => now(),
            ]
        );
    }

    return redirect()->route('admin.rekap.index', [
        'bulan' => $bulan,
        'tahun' => $tahun,
    ])->with('success', 'Rekap absensi bulan ini berhasil disimpan.');
}

public function exportDetailExcel($eskul_id, $bulan, $tahun){
    $namaBulan = date('F', mktime(0, 0, 0, $bulan, 10));
    $namaFile = "Rekap_Detail_{$namaBulan}_{$tahun}.xlsx";

    return Excel::download(new RekapDetailExport($eskul_id, $bulan, $tahun), $namaFile);
}

}
