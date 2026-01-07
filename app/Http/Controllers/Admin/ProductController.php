<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index', [
            'products' => Product::with('category')->paginate(10)
        ]);
    }

    public function create()
    {
        return view('admin.products.create', [
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {
        $product = Product::createProduct($request->all());

        return redirect()
            ->route('admin.products.show', $product)
            ->with('success', 'Tạo sản phẩm thành công');
    }

    public function show(Product $product)
    {
        $product->load('colors.sizes', 'category');
        return view('admin.products.show', compact('product'));
    }

    /**
     * NHẬP KHO
     */
    public function storeVariant(Request $request, Product $product)
    {
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('products', 'public');
        }

        $product->addStock([
            'color'    => $request->color,
            'size'     => $request->size,
            'quantity' => $request->quantity,
            'image'    => $imagePath
        ]);

        return back()->with('success', 'Nhập kho thành công');
    }
}
