<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategoryController;

/*
|--------------------------------------------------------------------------
| PUBLIC (Khách & User)
|--------------------------------------------------------------------------
*/
// Trang chủ
Route::get('/', [ProductController::class, 'index'])->name('home');

// Chi tiết sản phẩm (Cần name để view gọi route('products.show'))
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

/*
|--------------------------------------------------------------------------
| USER ACTION (Phải đăng nhập)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Mua hàng (Cần name để view gọi route('cart.buy'))
    Route::post('/buy/{product}', [CartController::class, 'buy'])->name('cart.buy');
});

/*
|--------------------------------------------------------------------------
| AUTH (Đăng nhập / Đăng ký)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN (Phải là Admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth','admin'])  // auth + admin role
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // ===== SẢN PHẨM =====
        Route::resource('products', AdminProductController::class);

        // Nhập kho / thêm variant
        Route::post('products/{product}/variant', [AdminProductController::class, 'storeVariant'])
            ->name('products.variant.store');

        // ===== USER =====
        Route::resource('users', AdminUserController::class);

        // ===== CATEGORY =====
        Route::resource('categories', CategoryController::class);
});