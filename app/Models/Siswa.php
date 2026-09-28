<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Siswa extends Authenticatable
{
    protected $table = 'siswas';
    protected $primaryKey = 'nis';
    public $incrementing = false; 
    protected $keyType = 'string'; // Ubah dari 'int' menjadi 'string'

    protected $fillable = ['nis', 'kelas', 'password'];
}
