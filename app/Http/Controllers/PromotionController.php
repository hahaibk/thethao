<?php

namespace App\Http\Controllers;

use App\Models\Product;

class PromotionController extends Controller
{
    public function index()
    {
        // Lấy các sản phẩm có promotion đang active
        $products = Product::with(['images', 'promotions'])
            ->whereHas('promotions', function ($q) {
                $q->where('is_active', 1)
                  ->where(function ($qq) {
                      $qq->whereNull('start_date')
                         ->orWhere('start_date', '<=', now());
                  })
                  ->where(function ($qq) {
                      $qq->whereNull('end_date')
                         ->orWhere('end_date', '>=', now());
                  });
            })
            ->latest()
            ->paginate(12);

        return view('shop.promotions.index', compact('products'));
    }
}
