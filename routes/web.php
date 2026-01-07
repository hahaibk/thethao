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

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Khách & User)
|--------------------------------------------------------------------------
*/
// Trang chủ
Route::get('/', [ProductController::class, 'index'])->name('home');

// Chi tiết sản phẩm
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

/*
|--------------------------------------------------------------------------
| USER ACTION (Phải đăng nhập)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Mua hàng
    Route::post('/buy/{product}', [CartController::class, 'buy'])->name('cart.buy');
});

/*
|--------------------------------------------------------------------------
| AUTH (Đăng nhập / Đăng ký / Logout)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (Phải là admin)
|--------------------------------------------------------------------------
*/
    Route::prefix('admin')
        ->middleware(['auth','admin'])
        ->name('admin.')
        ->group(function () {

            // Dashboard
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

            // ===== SẢN PHẨM =====
            Route::resource('products', AdminProductController::class);

            // Thêm variant sản phẩm
            Route::post('products/{product}/variant', [AdminProductController::class, 'storeVariant'])
                ->name('products.variant.store');

            // ===== USER =====
            Route::resource('users', AdminUserController::class);

            // ===== CATEGORY =====
            Route::resource('categories', CategoryController::class);
    });
