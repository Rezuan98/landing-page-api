<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\IndexController;
use App\Http\Controllers\backend\OrderController;
use App\Http\Controllers\backend\SizeController;
use App\Http\Controllers\backend\BrandController;
use App\Http\Controllers\backend\ProductController;



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::get('/admin/login', [IndexController::class, 'adminLogin'])->name('admin.login');








Route::middleware('auth')->group(function () {

Route::get('/', [IndexController::class, 'index'])->name('admin.dashboard');

// size
Route::get('/size/create', [SizeController::class, 'create'])->name('size.create');
Route::post('/size/store', [SizeController::class, 'store'])->name('size.store');
Route::get('/size/index', [SizeController::class, 'index'])->name('size.index');
Route::post('/size/delete/{id}', [SizeController::class, 'delete'])->name('size.delete');

Route::get('/brand/create', [BrandController::class, 'create'])->name('brand.create');
Route::post('/brand/store', [BrandController::class, 'store'])->name('brand.store');
Route::get('/brand/index', [BrandController::class, 'index'])->name('brand.index');
Route::post('/brand/delete/{id}', [BrandController::class, 'delete'])->name('brand.delete');


Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
Route::get('/product/index', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/show/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
Route::post('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
Route::post('/product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');

// Product image management routes
Route::post('/product/image/delete/{id}', [ProductController::class, 'deleteImage'])->name('product.image.delete');
Route::post('/product/image/primary/{id}', [ProductController::class, 'setPrimaryImage'])->name('product.image.primary');





// Order routes - Add these to your web.php file
Route::get('/order/index', [OrderController::class, 'index'])->name('index.order');
Route::get('/order/show/{id}', [OrderController::class, 'show'])->name('order.show');
Route::post('/order/update-status/{id}', [OrderController::class, 'updateStatus'])->name('order.update-status');
Route::post('/order/bulk-status-update', [OrderController::class, 'bulkStatusUpdate'])->name('order.bulk-status-update');
Route::post('/order/delete/{id}', [OrderController::class, 'delete'])->name('order.delete');











});

require __DIR__.'/auth.php';
