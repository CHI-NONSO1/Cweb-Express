<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'productid',
        'price',
        'category',
        'quantity',
        'description',
        'image',
        'total_price',
        'total_qty',
        'user_id',
        'shopping_token',

    ];
    protected $primaryKey = 'cartid';
    //This was added so that laravel will not add s to the table name
    protected $table = 'cart';
}
