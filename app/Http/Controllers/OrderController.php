<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Danh sách đơn hàng của user
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderByDesc('id')
            ->get();

        return view('shop.orders.index', compact('orders'));
    }

    /**
     * Chi tiết đơn hàng
     */
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items');

        return view('shop.orders.show', compact('order'));
    }
}
