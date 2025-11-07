<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'eskul_id',
        'nama',
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    public function getAuthIdentifierName()
    {
        return 'username';
    }

    // user (admin/petugas) milik satu eskul
    public function eskul()
    {
        return $this->belongsTo(Eskul::class, 'eskul_id');
    }

    // User bisa input banyak absensi
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'user_id');
    }

    public function rekap(){
         return $this->hasMany(RekapBulanan::class, 'user_id');
    }
    
}
