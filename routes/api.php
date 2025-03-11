<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\OrderController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\ProductApiController;
use App\Http\Controllers\OrderApiController;




// Route::get('/test', function() {
//     return response()->json(['message' => 'API is working']);
// });
// Order routes
Route::post('/orders', [OrderApiController::class, 'store']);
// or
// Route::post('/order/create', [OrderController::class, 'store']);

// Product routes
Route::post('/check-product-size', [ProductController::class, 'checkProductSize']);

Route::get('/products/search', [ProductController::class, 'searchProducts']);
Route::get('/categories', [ProductController::class, 'getCategories']);


// fetch products
Route::get('/products/collections', [ProductApiController::class, 'index']);
Route::get('/products/featured', [ProductApiController::class, 'getFeaturedProducts']);
Route::get('/products/search', [ProductApiController::class, 'searchProducts']);
Route::post('/check-product-size', [ProductApiController::class, 'checkProductSize']);
