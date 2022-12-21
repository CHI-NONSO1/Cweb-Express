<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserAuthentication;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [HomeController::class, 'index']);
Route::get('/express/{biz_id}', [ProductsController::class, 'getProductByCategory']);
//Route::get('express/{productid}', [ProductsController::class, 'getProductByProductId']);
Route::get('cart/{biz_id}', [CartController::class, 'index']);
Route::get('get-checkout-form', [CheckoutController::class, 'CheckoutForm']);
Route::post('/checkout-form', [CheckoutController::class, 'getCheckoutForm']);
Route::post('checkout/{biz_id}', [CheckoutController::class, 'createCheckout']);
Route::get('/checkout-status', [CheckoutController::class, 'getCheckoutStatus']);
Route::post('delete-cart/{biz_id}', [CartController::class, 'destroy']);
Route::post('increase-cart/{biz_id}', [CartController::class, 'increaseCart']);
Route::post('decrease-cart/{biz_id}', [CartController::class, 'decreaseCart']);
Route::post('/one-product', [ProductsController::class, 'getProductByProductId']);
/*-------------------------------------------------
|                     Admin Area
/*-------------------------------------------------*/
Route::prefix('admin')->group(function () {

    Route::get('/dashboard',  [UserAuthentication::class, 'getProfileByBizId']);
    Route::get('/register-form',  [UserAuthentication::class, 'registerForm']);
    Route::get('/login-form',  [UserAuthentication::class, 'loginForm']);
    Route::post('/register', [UserAuthentication::class, 'createAccount']);
    Route::post('/sign-in', [UserAuthentication::class, 'userLogin']);
    Route::post('/logout', [UserAuthentication::class, 'userLogout']);
    /*============================================================*/
    /*===========================================================*/
    Route::get('/add-product-form/{access_token}', [ProductsController::class, 'addproductForm']);
    Route::post('/add-product', [ProductsController::class, 'createProduct']);
    Route::get('/add-product-status/{access_token}', [ProductsController::class, 'addproductStatusForm']);
});
