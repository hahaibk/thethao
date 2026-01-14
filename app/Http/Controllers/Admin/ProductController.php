<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
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
            'category',
            'images' => function ($q) {
                $q->orderBy('sort_order');
            }
        ])
        ->withCount('variants')
        ->withSum('variants as total_stock', 'quantity');

    // 🔍 TÌM KIẾM THEO TÊN
    if ($request->filled('q')) {
        $query->where('name', 'like', '%' . $request->q . '%');
    }

    // 🗂 LỌC THEO DANH MỤC
    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }
    $products = $query->paginate(10); // 10 sản phẩm/trang
    $products = $query
        ->latest()
        ->paginate(10)
        ->withQueryString(); // giữ filter khi phân trang


    $categories = Category::all();

    return view('admin.products.index', compact('products', 'categories'));
}

    /* =========================
        FORM TẠO
    ========================== */
    public function create()
    {
        return view('admin.products.create', [
            'product'    => new Product(),
            'categories' => Category::all(),
        ]);
    }

    /* =========================
        LƯU SẢN PHẨM
    ========================== */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string',
            'price'       => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',

            // Ảnh chung
            'images'     => 'nullable|array',
            'images.*'   => 'image|max:2048',

            // Biến thể
            'variants'               => 'required|array|min:1',
            'variants.*.color'       => 'nullable|string',
            'variants.*.size'        => 'nullable|string',
            'variants.*.quantity'    => 'required|integer|min:0',

            // Ảnh biến thể
            'variants.*.images'      => 'nullable|array',
            'variants.*.images.*'    => 'image|max:2048',
        ]);

        Product::createProduct($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Tạo sản phẩm thành công');
    }

    /* =========================
        FORM SỬA
    ========================== */
    public function edit(Product $product)
    {
        $product->load([
            'images',
            'variants.images'
        ]);

        return view('admin.products.edit', [
            'product'    => $product,
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

            // Ảnh chung
            'images'     => 'nullable|array',
            'images.*'   => 'image|max:2048',

            // Biến thể
            'variants'               => 'required|array|min:1',
            'variants.*.id'          => 'nullable|exists:product_variants,id',
            'variants.*.color'       => 'nullable|string',
            'variants.*.size'        => 'nullable|string',
            'variants.*.quantity'    => 'required|integer|min:0',

            // Ảnh biến thể
            'variants.*.images'      => 'nullable|array',
            'variants.*.images.*'    => 'image|max:2048',
        ]);

        $product->updateProduct($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Cập nhật sản phẩm thành công');
    }

    /* =========================
        XÓA SẢN PHẨM
    ========================== */
    public function destroy(Product $product)
    {
        $product->deleteProduct();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Xóa sản phẩm thành công');
    }

    /* =========================
        XÓA ẢNH CHUNG (AJAX)
    ========================== */
    public function destroyImage(ProductImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(['success' => true]);
    }

    /* =========================
        XEM CHI TIẾT (ADMIN)
    ========================== */
    public function show(Product $product)
    {
        $product->load([
            'images',
            'variants.images'
        ]);

        return view('admin.products.show', compact('product'));
    }
}
