<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController; // USER
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| ADMIN CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\VariantImageController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\HomeSectionController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\PromotionController as AdminPromotionController;
use App\Http\Controllers\Admin\SportController;
use App\Http\Controllers\Admin\Ajax\CategoryAjaxController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

Route::get('/promotions', [PromotionController::class, 'index'])->name('promotions.index');

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
| ROUTES CẦN LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // LOGOUT
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /*
    | PROFILE
    */
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    /*
    | USER ORDERS (CHỈ ĐƠN CỦA USER)
    */
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    /*
    | CART
    */
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/buy/{product}', [CartController::class, 'buy'])->name('cart.buy');

    /*
    | CHECKOUT
    */
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout-success', [CheckoutController::class, 'success'])->name('checkout.success');

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')
        ->middleware('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

            // Orders (ADMIN – TẤT CẢ USER)
            Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
            Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');

            // Sports
            Route::resource('sports', SportController::class);

            // Ajax
            Route::get(
                'ajax/categories-by-sport/{sport}',
                [CategoryAjaxController::class, 'bySport']
            )->name('ajax.categories.bySport');

            // Products
            Route::resource('products', AdminProductController::class);

            Route::delete('product-images/{image}', [ProductImageController::class, 'destroy'])
                ->name('product_images.destroy');

            Route::delete('variant-images/{image}', [VariantImageController::class, 'destroy'])
                ->name('variant_images.destroy');

            Route::get('featured-products', [AdminProductController::class, 'featuredIndex'])
                ->name('products.featured');

            Route::post('featured-products/{product}', [AdminProductController::class, 'toggleFeatured'])
                ->name('products.featured.toggle');

            // Users
            Route::resource('users', UserController::class);

            // Categories
            Route::resource('categories', CategoryController::class);

            // Promotions
            Route::resource('promotions', AdminPromotionController::class);

            // Home sections
            Route::prefix('home_sections')
                ->name('homesection.')
                ->group(function () {
                    Route::resource('banner', HomeSectionController::class);
                    Route::resource('events', AdminEventController::class);
                    Route::resource('sales', SaleController::class);
                });
        });
});
    