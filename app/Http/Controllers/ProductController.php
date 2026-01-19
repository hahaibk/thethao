<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Event;
use App\Models\HomeSection;
use Illuminate\Http\Request;
use App\Models\Sport;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // BANNER
        $banners = HomeSection::where('type', 'banner')
            ->orderBy('sort_order', 'asc')
            ->get();

        $sections = $banners->map(function ($banner) {
            return [
                'title' => $banner->title,
                'subtitle' => $banner->subtitle,
                'image' => $banner->image,
                'link' => $banner->link,
            ];
        });
        $sports = Sport::with('categories')->get();
        // SẢN PHẨM NỔI BẬT + PROMOTION
        $products = Product::with(['images', 'promotions'])
            ->where('is_featured', 1)
            ->latest()
            ->take(8)
            ->get();

        $events = Event::latest()->take(3)->get();
        $randomProducts = Product::with('images')
            ->where('is_featured', 0)
            ->inRandomOrder()
            ->take(8)
            ->get();
            return view('shop.home.index', compact(
            'sections',
            'products',
            'randomProducts',
            'events',
            'sports'
        ));
        // 🔍 search theo tên
    if ($request->q) {
        $query->where('name','like','%'.$request->q.'%');
    }

    // lọc theo sport
    if ($request->sport) {
        $query->whereHas('category', function ($q) use ($request) {
            $q->where('sport_id', $request->sport);
        });
    }

    // lọc theo gender
    if ($request->gender) {
        $query->whereHas('category', function ($q) use ($request) {
            $q->where('gender', $request->gender);
        });
    }
    }

    public function show(Product $product)
    {
        $product->load(['images', 'variants', 'promotions']);
        $relatedProducts = Product::with('images')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();
        
        return view('shop.home.show', compact(
            'product',
            'relatedProducts'
        ));
    }
}
