<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $items = $request->items ?? [];
        return view('shop.checkout.index', compact('items'));
    }

    public function store(Request $request)
    {
        $cart = session('cart', []);

        DB::beginTransaction();

        try {
            foreach ($cart as $key => $item) {

                if (!isset($item['checked'])) continue;

                $product = Product::lockForUpdate()
                    ->find($item['product_id']);

                if (!$product) {
                    throw new \Exception('Sản phẩm không tồn tại');
                }

                if ($product->quantity < $item['qty']) {
                    throw new \Exception(
                        "Sản phẩm {$product->name} không đủ số lượng"
                    );
                }

                // Trừ kho
                $product->quantity -= $item['qty'];
                $product->save();
            }

            // Xóa item đã mua khỏi giỏ
            $cart = array_filter($cart, fn($i) => !isset($i['checked']));
            session(['cart' => $cart]);

            DB::commit();

            return redirect()->route('checkout.success');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function success()
    {
        return view('shop.checkout.success');
    }
}
