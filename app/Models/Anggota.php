<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggotas';
    protected $primaryKey = 'anggota_id';
    
    protected $fillable = [
        'eskul_id',
        'nama',
        'kelas',
        'nis',
        'jenis_kelamin',
        'no_hp',
    ];
    // Anggota milik 1 eskul
    public function eskul(){
        return $this->belongsTo(Eskul::class, 'eskul_id');
    }
    // Anggota punya banyak absensi
    public function absensi(){
        return $this->hasMany(Absensi::class, 'anggota_id');
    } 
}
