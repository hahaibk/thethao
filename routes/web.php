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

/*
|-------------------------------------------------------------------------- 
| PUBLIC ROUTES
|-------------------------------------------------------------------------- 
*/
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

        // Users
        Route::resource('users', AdminUserController::class);

        // Categories
        Route::resource('categories', CategoryController::class);

        // Delete variant image
        Route::delete(
            'variant-images/{variantImage}',
            [VariantImageController::class, 'destroy']
        )->name('variant_images.destroy');
    });
