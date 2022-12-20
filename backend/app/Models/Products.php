<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
        'price',
        'category',
        'quantity',
        'description',
        'image',
        'user_id',
        'rating',
        'feature_image'


    ];
    protected $primaryKey = 'userid';
}
