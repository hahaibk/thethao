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
    public function index()
    {
        $products = Product::with(['category','images'=>function($q){$q->orderBy('sort_order');}])
            ->withCount('variants')
            ->withSum('variants as total_stock','quantity')
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create', [
            'product'=>new Product(),
            'categories'=>Category::all()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string',
            'price'=>'required|numeric',
            'category_id'=>'required|exists:categories,id',
            'description'=>'nullable|string',
            'images'=>'nullable|array',
            'images.*'=>'image|max:2048',
            'variants'=>'required|array|min:1',
            'variants.*.color'=>'nullable|string',
            'variants.*.size'=>'nullable|string',
            'variants.*.quantity'=>'required|integer|min:0',
            'variants.*.price'=>'nullable|numeric',
            'variants.*.images'=>'nullable|array',
            'variants.*.images.*'=>'image|max:2048'
        ]);

        Product::createProduct($data);

        return redirect()->route('admin.products.index')->with('success','Tạo sản phẩm thành công');
    }

    public function edit(Product $product)
    {
        $product->load('variants.images');
        return view('admin.products.edit',[
            'product'=>$product,
            'categories'=>Category::all()
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'=>'required|string',
            'price'=>'required|numeric',
            'category_id'=>'required|exists:categories,id',
            'description'=>'nullable|string',
            'images'=>'nullable|array',
            'images.*'=>'image|max:2048',
            'variants'=>'required|array|min:1',
            'variants.*.id'=>'nullable|exists:product_variants,id',
            'variants.*.color'=>'nullable|string',
            'variants.*.size'=>'nullable|string',
            'variants.*.quantity'=>'required|integer|min:0',
            'variants.*.price'=>'nullable|numeric',
            'variants.*.images'=>'nullable|array',
            'variants.*.images.*'=>'image|max:2048'
        ]);

        $product->updateProduct($data);

        return redirect()->route('admin.products.index')->with('success','Cập nhật sản phẩm thành công');
    }

    public function destroy(Product $product)
    {
        $product->deleteProduct();
        return redirect()->route('admin.products.index')->with('success','Xóa sản phẩm thành công');
    }

    // AJAX Xóa ảnh
    public function destroyImage(ProductImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();
        return response()->json(['success'=>true]);
    }
    public function show($id)
{
    $product = Product::with('images')->findOrFail($id);
    return view('admin.products.show', compact('product'));
}
}
