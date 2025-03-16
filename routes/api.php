<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\OrderController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\ProductApiController;
use App\Http\Controllers\OrderApiController;
use App\Http\Controllers\SliderApiController;
use App\Http\Controllers\backend\FaqController;
use App\Http\Controllers\SettingController;

use App\Http\Controllers\FooterSocialApiController;




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
Route::get('/products/{id}', [ProductApiController::class, 'getProduct']);



Route::get('/sliders', [SliderApiController::class,'getSliders']);



// Logo API
Route::get('/logo', [App\Http\Controllers\backend\LogoController::class, 'getActive']);


// API Route to get active FAQs for frontend
Route::get('/faqs', [FaqController::class, 'getActiveFaqs']);

Route::get('/settings', [SettingController::class, 'getSettings']);

Route::get('/hero', [App\Http\Controllers\backend\HeroController::class, 'getActiveHero']);


// Add this to your routes/api.php file

Route::get('/footer-social', [FooterSocialApiController::class,'index']);