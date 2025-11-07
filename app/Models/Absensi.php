<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
     protected $table = 'absensis';
     protected $primaryKey = 'absensi_id';
    protected $fillable = [
        'anggota_id',
        'eskul_id',
        'jadwal_id',
        'user_id',
        'tanggal',
        'status',
        'keterangan',
    ];
    // 1 anggota hanya memiliki 1 absen
    public function anggota(){
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }
    // Absen di cata 1 user (petugas/absensi tiap eskul/ketua eskul/wakil ketua )
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jadwal()
    {
        return $this->belongsTo(JadwalEskul::class, 'jadwal_id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}
