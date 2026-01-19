<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Sport;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /* =========================
        DANH SÁCH SẢN PHẨM
    ========================== */
    public function index(Request $request)
    {
        $query = Product::with([
                'category.sport',
                'images' => fn($q) => $q->orderBy('sort_order')
            ])
            ->withCount('variants')
            ->withSum('variants as total_stock', 'quantity');

        // 🔍 Tìm theo tên
        if ($request->filled('q')) {
            $query->where('name', 'like', '%'.$request->q.'%');
        }

        // 🏀 Lọc theo sport (THÊM)
        if ($request->filled('sport_id')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('sport_id', $request->sport_id);
            });
        }

        // 🗂 Lọc theo category (CŨ)
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->latest()->paginate(10)->withQueryString();

        return view('admin.products.index', [
            'products'   => $products,
            'categories' => Category::all(),
            'sports'     => Sport::orderBy('sort_order')->get(),
        ]);
    }

    /* =========================
        FORM TẠO
    ========================== */
    public function create()
    {
        return view('admin.products.create', [
            'product'    => new Product(),
            'sports'     => Sport::orderBy('sort_order')->get(),
            'categories' => Category::all(), // fallback
        ]);
    }

    /* =========================
        LƯU
    ========================== */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string',
            'price'       => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',

            'images'     => 'nullable|array',
            'images.*'   => 'image|max:2048',

            'variants'               => 'required|array|min:1',
            'variants.*.color'       => 'nullable|string',
            'variants.*.size'        => 'nullable|string',
            'variants.*.quantity'    => 'required|integer|min:0',
            'variants.*.images'      => 'nullable|array',
            'variants.*.images.*'    => 'image|max:2048',
        ]);

        Product::createProduct($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Tạo sản phẩm thành công');
    }

    /* =========================
        FORM SỬA
    ========================== */
    public function edit(Product $product)
    {
        $product->load(['images','variants.images','category.sport']);

        return view('admin.products.edit', [
            'product'    => $product,
            'sports'     => Sport::orderBy('sort_order')->get(),
            'categories' => Category::all(),
        ]);
    }

    /* =========================
        CẬP NHẬT
    ========================== */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => 'required|string',
            'price'       => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',

            'images'     => 'nullable|array',
            'images.*'   => 'image|max:2048',

            'variants'               => 'required|array|min:1',
            'variants.*.id'          => 'nullable|exists:product_variants,id',
            'variants.*.color'       => 'nullable|string',
            'variants.*.size'        => 'nullable|string',
            'variants.*.quantity'    => 'required|integer|min:0',
            'variants.*.images'      => 'nullable|array',
            'variants.*.images.*'    => 'image|max:2048',
        ]);

        $product->updateProduct($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Cập nhật sản phẩm thành công');
    }

    /* =========================
        XÓA
    ========================== */
    public function destroy(Product $product)
    {
        $product->deleteProduct();

        return redirect()->route('admin.products.index')
            ->with('success', 'Xóa sản phẩm thành công');
    }
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('admin.products.show', compact('product'));
    }
    public function toggleFeatured(Product $product)
    {
        $product->update([
            'is_featured' => !$product->is_featured
        ]);

        return back()->with('success', 'Cập nhật sản phẩm nổi bật thành công');
    }
    public function featuredIndex()
{
    $products = Product::where('is_featured', true)
        ->latest()
        ->paginate(10);

    return view('admin.products.featured', compact('products'));
}
 }
