<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admins';
    // Primary key otomatis 'id'

    protected $fillable = ['username', 'password'];
}