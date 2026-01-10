<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\VariantImageController;
use App\Http\Controllers\Admin\HomeSectionController;
use App\Http\Controllers\Admin\ProductImageController;

/*
|-------------------------------------------------------------------------- 
| PUBLIC ROUTES
|-------------------------------------------------------------------------- 
*/
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

/*
|-------------------------------------------------------------------------- 
| USER (LOGIN REQUIRED)
|-------------------------------------------------------------------------- 
*/
Route::middleware('auth')->group(function () {
    Route::post('/buy/{product}', [CartController::class, 'buy'])->name('cart.buy');
});

/*
|-------------------------------------------------------------------------- 
| AUTH
|-------------------------------------------------------------------------- 
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|-------------------------------------------------------------------------- 
| ADMIN
|-------------------------------------------------------------------------- 
*/
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Products (XỬ LÝ VARIANT + IMAGE BÊN TRONG)
        Route::resource('products', AdminProductController::class);
 // Xóa ảnh sản phẩm
        Route::delete('product-images/{image}', [ProductImageController::class,'destroy'])
            ->name('product_images.destroy');

        // Xóa ảnh variant
        Route::delete('variant-images/{image}', [VariantImageController::class,'destroy'])
            ->name('variant_images.destroy');
        // Users
        Route::resource('users', AdminUserController::class);

        // Categories
        Route::resource('categories', CategoryController::class);

        // Delete variant image
        Route::delete(
            'variant-images/{variantImage}',
            [VariantImageController::class, 'destroy']
        )->name('variant_images.destroy');
        Route::prefix('home_sections')->name('homesection.')->group(function() {
            Route::resource('banner', HomeSectionController::class);
        });
            Route::resource('users', Admin\UserController::class);

    });
