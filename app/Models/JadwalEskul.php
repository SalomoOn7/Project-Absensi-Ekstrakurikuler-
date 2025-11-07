<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalEskul extends Model
{
    use HasFactory;

    protected $table = 'jadwal_eskul';
    protected $primaryKey = 'jadwal_id';

    protected $fillable = [
        'eskul_id',
        'hari',
        'waktu_mulai',
        'waktu_selesai',
    ];
    public function eskul(){
        return $this->belongsTo(Eskul::class, 'eskul_id', 'eskul_id');
    }
}
