<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        $products = Products::select(
            'productid',
            'product_name',
            'price',
            'category',
            'quantity',
            'description',
            'image',
            'user_id',
            'rating',
            'feature_image',
            'created_at',
            'updated_at',
        )->get();
        return view('index');
    }
}
