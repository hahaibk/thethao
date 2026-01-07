<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Tổng số sản phẩm
        $totalProducts = Product::count();

        // Tổng danh mục
        $totalCategories = Category::count();

        // Tổng người dùng
        $totalUsers = User::count();

        // Tổng tồn kho (tính từ variants JSON)
        $totalStock = Product::all()->sum(function ($product) {
            return $product->totalStock();
        });

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalUsers',
            'totalStock'
        ));
    }
}
