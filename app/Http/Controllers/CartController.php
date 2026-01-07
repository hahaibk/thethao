<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function buy(Product $product)
    {
        // tạm thời chỉ test cho route chạy
        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ!');
    }
}
