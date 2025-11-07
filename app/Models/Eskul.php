<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eskul extends Model
{
    protected $table = 'eskuls';
    protected $primaryKey = 'eskul_id';

    protected $fillable = [
        'nama_eskul',
        'deskripsi',
    ];
    // 1 eskul memiliki banyak anggota 
    public function anggota(){
        return $this->hasMany(Anggota::class, 'eskul_id');
    }
    //1 eskul memiliki banyak user seperi admin dan petugas
    public function users(){
        return $this->hasMany(User::class, 'eskul_id');
    }
    public function pembina()
    {
        return $this->hasOne(User::class, 'eskul_id', 'eskul_id')->where('role', 'admin');
    }
    public function getRouteKeyName()
    {
        return 'eskul_id';
    }

}
