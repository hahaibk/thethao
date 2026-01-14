<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\EventController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\VariantImageController;
use App\Http\Controllers\Admin\HomeSectionController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\SaleController;


/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
// routes/web.php
Route::get('/events/{event}', [EventController::class, 'show'])
    ->name('events.show');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

/*
|--------------------------------------------------------------------------
| ROUTES CẦN LOGIN + CHECK LOCK
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/buy/{product}', [CartController::class, 'buy'])->name('cart.buy');

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')
        ->middleware('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'index'])
                ->name('dashboard');

            // Products
            Route::resource('products', AdminProductController::class);

            // Xóa ảnh sản phẩm
            Route::delete('product-images/{image}', [ProductImageController::class,'destroy'])
                ->name('product_images.destroy');

            // Xóa ảnh variant
            Route::delete('variant-images/{image}', [VariantImageController::class,'destroy'])
                ->name('variant_images.destroy');

            // Users
            Route::resource('users', UserController::class);

            // Categories
            Route::resource('categories', CategoryController::class);

            // Home sections
            Route::prefix('home_sections')->name('homesection.')->group(function () {
                Route::resource('banner', HomeSectionController::class);
                Route::resource('events', AdminEventController::class);
                Route::resource('sales', SaleController::class);

            });
        });
});
