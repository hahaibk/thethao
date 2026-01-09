<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('variants.images','category')
            ->withSum('variants as total_stock','quantity')
            ->withCount('variants')
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.form', [
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
            'variants'=>'required|array|min:1',
            'variants.*.color'=>'required|string',
            'variants.*.size'=>'required|string',
            'variants.*.quantity'=>'required|integer|min:0',
            'variants.*.price'=>'nullable|numeric',
            'variants.*.images'=>'required|array|min:1',
            'variants.*.images.*'=>'required|image|max:2048',
            'images'=>'nullable|array',
            'images.*'=>'image|max:2048'
        ]);

        Product::createProduct($data);

        return redirect()->route('admin.products.index')->with('success','Tạo sản phẩm thành công');
    }

    public function edit(Product $product)
    {
        $product->load('variants.images');
        return view('admin.products.form',['product'=>$product,'categories'=>Category::all()]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'=>'required|string',
            'price'=>'required|numeric',
            'category_id'=>'required|exists:categories,id',
            'description'=>'nullable|string',
            'variants'=>'required|array|min:1',
            'variants.*.id'=>'nullable|exists:product_variants,id',
            'variants.*.color'=>'required|string',
            'variants.*.size'=>'required|string',
            'variants.*.quantity'=>'required|integer|min:0',
            'variants.*.price'=>'nullable|numeric',
            'variants.*.images'=>'nullable|array',
            'variants.*.images.*'=>'image|max:2048',
            'images'=>'nullable|array',
            'images.*'=>'image|max:2048'
        ]);

        $product->updateProduct($data);

        return redirect()->route('admin.products.index')->with('success','Cập nhật sản phẩm thành công');
    }

    public function destroy(Product $product)
    {
        $product->deleteProduct();
        return redirect()->route('admin.products.index')->with('success','Xóa sản phẩm thành công');
    }

    public function show(Product $product)
    {
        $product->load('images','variants.images');
        return view('admin.products.show',compact('product'));
    }
}
