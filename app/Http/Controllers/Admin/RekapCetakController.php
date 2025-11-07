<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapDetailExport;
use App\Exports\RekapExport;

class RekapCetakController extends Controller
{

    public function index(){
        $rekaps = DB::table('rekap_bulanan')
    ->join('eskuls', 'rekap_bulanan.eskul_id', '=', 'eskuls.eskul_id')
    ->select(
        'rekap_bulanan.eskul_id',
        'eskuls.nama_eskul as nama_eskul',
        'rekap_bulanan.bulan',
        'rekap_bulanan.tahun',
        DB::raw('SUM(total_hadir) as total_hadir'),
        DB::raw('SUM(total_izin) as total_izin'),
        DB::raw('SUM(total_sakit) as total_sakit'),
        DB::raw('SUM(total_alpha) as total_alpha')
    )
    ->groupBy('rekap_bulanan.eskul_id', 'eskuls.nama_eskul', 'rekap_bulanan.bulan', 'rekap_bulanan.tahun')
    ->orderBy('tahun', 'desc')
    ->orderBy('bulan', 'desc')
    ->get();


        return view('superadmin.rekap.index', compact('rekaps'));
    }


    protected $namaBulan = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    ];

    public function cetakPDF(Request $request ,$eskul_id, $bulan, $tahun)
    {
        $eskul = DB::table('eskuls')->where('eskul_id', $eskul_id)->first();
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));
        $bulanNama = $this->namaBulan[$bulan];

        $rekaps = DB::table('rekap_bulanan')
        ->join('eskuls', 'rekap_bulanan.eskul_id', '=', 'eskuls.eskul_id')
        ->select(
            'eskuls.nama_eskul as nama_eskul',
            DB::raw('SUM(total_hadir) as total_hadir'),
            DB::raw('SUM(total_izin) as total_izin'),
            DB::raw('SUM(total_sakit) as total_sakit'),
            DB::raw('SUM(total_alpha) as total_alpha')
        )
        ->where('rekap_bulanan.eskul_id', $eskul_id)
        ->where('bulan', $bulan)
        ->where('tahun', $tahun)
        ->groupBy('eskuls.nama_eskul')
        ->first();

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('superadmin.rekap.pdf', compact('rekaps', 'bulan', 'tahun', 'eskul', 'bulanNama'))
        ->setPaper('A4', 'portrait');

    return $pdf->stream("Rekap_{$eskul->nama_eskul}_{$bulanNama}_{$tahun}.pdf");
    }

    public function cetakExcel(Request $request, $eskul_id, $bulan, $tahun)
    {
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));
        $bulanNama = $this->namaBulan[$bulan];

        return Excel::download(new RekapExport($eskul_id, $bulan, $tahun), "Rekap_Absensi_{$bulanNama}_{$tahun}.xlsx");
    }
    public function exportDetailExcel($eskul_id, $bulan, $tahun)
{
    return Excel::download(new RekapDetailExport($eskul_id, $bulan, $tahun), 'Rekap_Detail_Eskul.xlsx');
}
}
