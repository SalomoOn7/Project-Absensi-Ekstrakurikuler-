<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RekapExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $eskul_id;
    protected $bulan;
    protected $tahun;

    public function __construct($eskul_id, $bulan, $tahun)
    {
        $this->eskul_id = $eskul_id;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        return DB::table('rekap_bulanan')
            ->join('eskuls', 'rekap_bulanan.eskul_id', '=', 'eskuls.eskul_id')
            ->select(
                'eskuls.nama_eskul as nama_eskul',
                DB::raw("CASE 
                    WHEN bulan = '01' THEN 'Januari'
                    WHEN bulan = '02' THEN 'Februari'
                    WHEN bulan = '03' THEN 'Maret'
                    WHEN bulan = '04' THEN 'April'
                    WHEN bulan = '05' THEN 'Mei'
                    WHEN bulan = '06' THEN 'Juni'
                    WHEN bulan = '07' THEN 'Juli'
                    WHEN bulan = '08' THEN 'Agustus'
                    WHEN bulan = '09' THEN 'September'
                    WHEN bulan = '10' THEN 'Oktober'
                    WHEN bulan = '11' THEN 'November'
                    WHEN bulan = '12' THEN 'Desember'
                END AS Bulan"),
                'rekap_bulanan.tahun as Tahun',
                DB::raw('SUM(total_hadir) as Total_Hadir'),
                DB::raw('SUM(total_izin) as Total_Izin'),
                DB::raw('SUM(total_sakit) as Total_Sakit'),
                DB::raw('SUM(total_alpha) as Total_Alpha')
            )
            ->where('rekap_bulanan.eskul_id', $this->eskul_id)
            ->where('rekap_bulanan.bulan', $this->bulan)
            ->where('rekap_bulanan.tahun', $this->tahun)
            ->groupBy('eskuls.nama_eskul', 'rekap_bulanan.bulan', 'rekap_bulanan.tahun')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama Eskul',
            'Bulan',
            'Tahun',
            'Total Hadir',
            'Total Izin',
            'Total Sakit',
            'Total Alpha'
        ];
    }
}
