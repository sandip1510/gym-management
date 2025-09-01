<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;   // 👈 import
use Spatie\Permission\Traits\HasRoles; // (if using roles)

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;  // 👈 add HasApiTokens here

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
