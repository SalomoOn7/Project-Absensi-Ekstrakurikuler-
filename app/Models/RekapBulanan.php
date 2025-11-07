<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapBulanan extends Model
{
    use HasFactory;

    protected $table = 'rekap_bulanan';
    protected $primaryKey = 'rekap_id';
    public $timestamps = false;

    protected $fillable = [
        'eskul_id',
        'anggota_id',
        'bulan',
        'tahun',
        'total_hadir',
        'total_izin',
        'total_sakit',
        'total_alpha',
        'dibuat_oleh',
        'dibuat_pada'
    ];
}
