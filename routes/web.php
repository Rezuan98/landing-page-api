<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\IndexController;
use App\Http\Controllers\backend\OrderController;
use App\Http\Controllers\backend\SizeController;
use App\Http\Controllers\backend\BrandController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\SliderController;
use App\Http\Controllers\backend\LogoController;
use App\Http\Controllers\backend\FooterSocialController;
use App\Http\Controllers\backend\FaqController;



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


Route::get('/product/create', [ProductController::class,'create'])->name('product.create');
Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
Route::get('/product/index', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/show/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
Route::post('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
Route::post('/product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');

// Product image management routes
Route::post('/product/image/delete/{id}', [ProductController::class, 'deleteImage'])->name('product.image.delete');
Route::post('/product/image/primary/{id}', [ProductController::class, 'setPrimaryImage'])->name('product.image.primary');





// Order routes 
Route::get('/order/index', [OrderController::class, 'index'])->name('index.order');
Route::get('/order/show/{id}', [OrderController::class, 'show'])->name('order.show');
Route::post('/order/update-status/{id}', [OrderController::class, 'updateStatus'])->name('order.update-status');
Route::post('/order/bulk-status-update', [OrderController::class, 'bulkStatusUpdate'])->name('order.bulk-status-update');
Route::post('/order/delete/{id}', [OrderController::class, 'delete'])->name('order.delete');




// Slider routes
Route::get('/slider/create', [SliderController::class, 'create'])->name('slider.create');
Route::post('/slider/store', [SliderController::class, 'store'])->name('slider.store');
Route::get('/slider/index', [SliderController::class, 'index'])->name('slider.index');
Route::post('/slider/delete/{id}', [SliderController::class, 'delete'])->name('slider.delete');



// Add these to your web.php file




// Admin Routes for FAQ Management
Route::get('/faq/index', [FaqController::class, 'index'])->name('faq.index');
Route::get('/faq/create', [FaqController::class, 'create'])->name('faq.create');
Route::post('/faq/store', [FaqController::class, 'store'])->name('faq.store');
Route::get('/faq/edit/{id}', [FaqController::class, 'edit'])->name('faq.edit');
Route::post('/faq/update/{id}', [FaqController::class, 'update'])->name('faq.update');
Route::post('/faq/delete/{id}', [FaqController::class, 'delete'])->name('faq.delete');
Route::post('/faq/update-order', [FaqController::class, 'updateOrder'])->name('faq.update-order');







// Logo Routes
Route::get('/logo/edit', [LogoController::class, 'edit'])->name('logo.edit');
Route::post('/logo/update', [LogoController::class, 'update'])->name('logo.update');

// Footer Social Links Routes
Route::get('/footer/edit', [FooterSocialController::class, 'edit'])->name('footer.edit');
Route::post('/footer/update',[FooterSocialController::class, 'update'])->name('footer.update');


Route::get('/hero/settings', [App\Http\Controllers\backend\HeroController::class, 'index'])->name('hero.index');
Route::post('/hero/update', [App\Http\Controllers\backend\HeroController::class, 'update'])->name('hero.update');

});

require __DIR__.'/auth.php';
