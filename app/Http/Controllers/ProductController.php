<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // ❌ KHÔNG middleware auth

    // Trang danh sách (guest xem được)
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->latest()
            ->paginate(12);

        return view('home.index', compact('products'));
    }

    // Trang chi tiết (guest xem được)
    public function show(Product $product)
    {
        return view('home.show', compact('product'));
    }
}
