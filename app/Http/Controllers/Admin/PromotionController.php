<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Product;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        // load luôn product cho khỏi query N+1 nếu cần hiển thị
        $promotions = Promotion::with('products')
            ->latest()
            ->paginate(15);

        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        // ✅ có danh sách sản phẩm để chọn
        $products = Product::all();

        return view('admin.promotions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required',
            'type'      => 'required|in:percent,fixed',
            'value'     => 'required|numeric|min:0',
            'start_at'  => 'nullable|date',
            'end_at'    => 'nullable|date|after_or_equal:start_at',
            'is_active' => 'boolean',
            'products'  => 'nullable|array'
        ]);

        $promotion = Promotion::create($data);

        // ✅ GÁN SẢN PHẨM
        if (!empty($data['products'])) {
            $promotion->products()->sync($data['products']);
        }

        return redirect()
            ->route('admin.promotions.index')
            ->with('success', 'Tạo khuyến mãi thành công');
    }

    public function edit(Promotion $promotion)
    {
        $products = Product::all();

        // ✅ QUAN TRỌNG – danh sách product đã gán
        $selectedProducts = $promotion
            ->products()
            ->pluck('products.id')
            ->toArray();

        return view(
            'admin.promotions.edit',
            compact('promotion', 'products', 'selectedProducts')
        );
    }

    public function update(Request $request, Promotion $promotion)
    {
        $data = $request->validate([
            'name'      => 'required',
            'type'      => 'required|in:percent,fixed',
            'value'     => 'required|numeric|min:0',
            'start_at'  => 'nullable|date',
            'end_at'    => 'nullable|date|after_or_equal:start_at',
            'is_active' => 'boolean',
            'products'  => 'nullable|array'
        ]);

        $promotion->update($data);

        // ✅ SYNC LẠI SẢN PHẨM
        $promotion->products()->sync($data['products'] ?? []);

        return redirect()
            ->route('admin.promotions.index')
            ->with('success', 'Cập nhật thành công');
    }

    public function destroy(Promotion $promotion)
    {
        // ✅ xoá pivot trước
        $promotion->products()->detach();
        $promotion->delete();

        return back()->with('success', 'Đã xoá khuyến mãi');
    }
}
