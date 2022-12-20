<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
        'fullname',
        'phoneno',
        'email',
        'address',
        'tracking_id',
        'product_id',
        'price',
        'category',
        'quantity',
        'description',
        'image',
        'total_price',
        'total_qty',
        'biz_name',

    ];
    protected $primaryKey = 'orderid';
}
