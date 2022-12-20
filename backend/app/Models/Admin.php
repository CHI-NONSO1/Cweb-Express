<?php

namespace App\Models;

use App\Models\Traits\HasAdminUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
//use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasAdminUuid;

    protected $fillable = [
        'firstname',
        'active_login',
        'lastname',
        'email',
        'image',
        'password',
        'dob',
        'city',
        'adminid',
        'phoneno',
        'duty',
        'address',
        'country',
        'balance'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
