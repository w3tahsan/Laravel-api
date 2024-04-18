<?php

use App\Http\Controllers\API\CartApiController;
use App\Http\Controllers\API\CategoryApiController;
use App\Http\Controllers\API\CustomerAuthentication;
use App\Http\Controllers\API\ProductApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group( function () {
    Route::post('/category/store', [CategoryApiController::class, 'category_store']);
    Route::get('/category/show/{id}', [CategoryApiController::class, 'category_show']);
    Route::post('/category/update/{id}', [CategoryApiController::class, 'category_update']);
    Route::delete('/category/delete/{id}', [CategoryApiController::class, 'category_delete']);
});

//customer authentication]
Route::post('/customer/register', [CustomerAuthentication::class, 'customer_register']);
Route::post('/customer/login', [CustomerAuthentication::class, 'customer_login']);
Route::post('/customer/logout', [CustomerAuthentication::class, 'customer_logout']);



//category
Route::get('/get/category', [CategoryApiController::class, 'get_category']);

//product
Route::get('/get/product', [ProductApiController::class, 'get_product']);
Route::get('/get/product/details/{slug}', [ProductApiController::class, 'get_product_details']);

//Cart
Route::post('/cart/store', [CartApiController::class, 'cart_store']);

