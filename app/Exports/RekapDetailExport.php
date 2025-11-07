<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RekapDetailExport implements FromCollection, WithHeadings, ShouldAutoSize
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
        return DB::table('absensis')
            ->join('anggotas', 'absensis.anggota_id', '=', 'anggotas.anggota_id')
            ->join('jadwal_eskul', 'absensis.jadwal_id', '=', 'jadwal_eskul.jadwal_id')
            ->join('eskuls', 'anggotas.eskul_id', '=', 'eskuls.eskul_id')
            ->select(
                'eskuls.nama_eskul as Nama_Eskul',
                'anggotas.nama as Nama_Anggota',
                'anggotas.nis as NIS',
                'anggotas.kelas as Kelas',
                'jadwal_eskul.hari as Hari',
                DB::raw('DATE(absensis.created_at) as Tanggal_Absen'),
                'absensis.status as Status'
            )
            ->where('eskuls.eskul_id', $this->eskul_id)
            ->whereMonth('absensis.created_at', $this->bulan)
            ->whereYear('absensis.created_at', $this->tahun)
            ->orderBy('anggotas.nama')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama Eskul',
            'Nama Anggota',
            'NIS',
            'Kelas',
            'Hari',
            'Tanggal Absen',
            'Status',
        ];
    }
}
