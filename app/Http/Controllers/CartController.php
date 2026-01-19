<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // ================= HIỂN THỊ GIỎ HÀNG =================
    public function index()
    {
        if (Auth::check()) {

            $cart = Cart::with('product.images')
                ->where('user_id', Auth::id())
                ->get()
                ->mapWithKeys(function ($item) {
                    return [
                        $item->id => [
                            'id'    => $item->product->id,
                            'name'  => $item->product->name,
                            // ✅ GIÁ LẤY TỪ PRODUCT
                            'price' => $item->product->finalPrice(),
                            'qty'   => $item->qty,
                            'image' => optional($item->product->images->first())->image_path,
                            'size'  => $item->size,
                        ]
                    ];
                })
                ->toArray();

        } else {
            $cart = session()->get('cart', []);
        }

        return view('shop.cart.index', compact('cart'));
    }

    // ================= THÊM VÀO GIỎ =================
    public function buy(Request $request, Product $product)
    {
        $qty  = max(1, (int) $request->input('qty', 1));
        $size = $request->input('size');

        // ================= ĐÃ LOGIN → DB =================
        if (Auth::check()) {

            $cart = Cart::where([
                'user_id'    => Auth::id(),
                'product_id' => $product->id,
                'size'       => $size,
            ])->first();

            if ($cart) {
                // ✅ tăng số lượng
                $cart->increment('qty', $qty);
            } else {
                // ✅ tạo mới (KHÔNG có price)
                Cart::create([
                    'user_id'    => Auth::id(),
                    'product_id' => $product->id,
                    'size'       => $size,
                    'qty'        => $qty,
                ]);
            }

        }
        // ================= CHƯA LOGIN → SESSION =================
        else {

            $cart = session()->get('cart', []);
            $key = $product->id . '_' . $size;

            if (isset($cart[$key])) {
                $cart[$key]['qty'] += $qty;
            } else {
                $cart[$key] = [
                    'id'    => $product->id,
                    'name'  => $product->name,
                    'price' => $product->finalPrice(),
                    'qty'   => $qty,
                    'image' => optional($product->images->first())->image_path,
                    'size'  => $size,
                ];
            }

            session()->put('cart', $cart);
        }

        return redirect()
            ->route('cart.index')
            ->with('success', 'Đã thêm sản phẩm vào giỏ hàng');
    }
}
