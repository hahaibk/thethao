<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\HomeSection; 

class ProductController extends Controller
{
    // Trang danh sách (guest xem được)
    public function index(Request $request)
    {
        // Lấy banner
        $banners = HomeSection::where('type','banner')
                    ->where('is_active',1)
                    ->orderBy('sort_order','asc')
                    ->get();

        // Chuyển thành format Blade (nếu muốn sections khác)
        $sections = $banners->map(function($banner){
            return [
                'title' => $banner->title,
                'subtitle' => $banner->subtitle ?? null,
                'image' => $banner->image,      // phải đúng với cột DB
                'link' => $banner->link ?? null,
                'background_color' => '#f8f9fa',
            ];
        });

        // Lấy sản phẩm, chắc chắn main_image là relative path
        $products = Product::with('category')
            ->latest()
            ->paginate(12);

        // Pass cả sections + banners + products vào view
        return view('shop.home.index', compact('sections','banners','products'));
    }

    // Trang chi tiết
    public function show(Product $product)
    {
        return view('shop.home.show', compact('product'));
    }
}
