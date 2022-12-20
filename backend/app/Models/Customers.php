<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;
    protected $fillable = [
        'fullname',
        'phoneno',
        'email',
        'address',
        'balance',
        'image',



    ];
    protected $primaryKey = 'customerid';
}
