<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProcessedOrderController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserAuthentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
|-----------------------------
| Processed Order Routes
|-----------------------------
*/

Route::post('/add-processed-order', [ProcessedOrderController::class, 'createProcessedOrder']);
Route::post('/delete-processed-order', [ProcessedOrderController::class, 'deleteProcessedOrder']);
Route::post('/one-processed-order', [ProcessedOrderController::class, 'getProcessedOrderByTrackingId']);
Route::post('/all-processed-order', [ProcessedOrderController::class, 'getAllProcessedOrder']);
/*
|-----------------------------
| Orders Routes
|-----------------------------
*/
Route::post('/order', [OrdersController::class, 'createOrder']);
Route::post('/cancel-order', [OrdersController::class, 'CancelOrder']);
Route::post('/oneorder', [OrdersController::class, 'getOrderByTrackingId']);
Route::post('/allorders', [OrdersController::class, 'getAllOrders']);
Route::post('/locateme', [OrdersController::class, 'getLocation']);
/*
|-----------------------------
| Checkout Routes
|-----------------------------
*/
Route::post('/checkout', [CheckoutController::class, 'createCheckout']);
Route::post('/remove-checkout', [CheckoutController::class, 'RemoveCheckout']);
Route::post('/allcheckout', [CheckoutController::class, 'getAllCheckouts']);
Route::post('/onecheckout', [CheckoutController::class, 'getCheckoutByTrackingId']);


/*
|-----------------------------
| Products Routes
|-----------------------------
*/
Route::post('/add-product', [ProductsController::class, 'createProduct']);
Route::post('/update-product', [ProductsController::class, 'updateProduct']);
Route::post('/update-product', [ProductsController::class, 'updateProduct']);
Route::post('/delete-product', [ProductsController::class, 'destroyProduct']);
Route::post('/one-product', [ProductsController::class, 'getProductByProductId']);
Route::post('/category', [ProductsController::class, 'getProductByCategory']);
Route::post('/price', [ProductsController::class, 'getProductByPrice']);
Route::post('/search-products', [ProductsController::class, 'getSearchProducts']);
Route::get('/homeproducts', [ProductsController::class, 'getAllProducts']);

/*
|-----------------------------
| User Routes
|-----------------------------
*/
Route::post('/register', [UserAuthentication::class, 'createAccount']);
Route::post('/login', [UserAuthentication::class, 'userLogin']);
Route::post('/update-acoount', [UserAuthentication::class, 'updateAccount']);
Route::post('/logout', [UserAuthentication::class, 'userLogout']);

/*
|-----------------------------
| Admin Routes
|-----------------------------
*/
Route::post('/sign-up', [AdminController::class, 'createAdminAccount']);
Route::post('/sign-in', [AdminController::class, 'adminLogin']);
Route::post('/admin-update', [AdminController::class, 'updateAdmin']);
Route::post('/sign-out', [AdminController::class, 'adminLogout']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [UserAuthentication::class, 'profile']);
    Route::get('/express-user', [AdminController::class, 'getAllUsers']);
});
