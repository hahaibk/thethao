<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Event;
use App\Models\HomeSection;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // ===== BANNER =====
        $banners = HomeSection::where('type', 'banner')
            ->orderBy('sort_order', 'asc')
            ->get();

        $sections = $banners->map(function ($banner) {
            return [
                'title' => $banner->title,
                'subtitle' => $banner->subtitle,
                'image' => $banner->image,
                'link' => $banner->link,
                'background_color' => '#f8f9fa',
            ];
        });

        // ===== PRODUCT =====
        $products = Product::with('images')
            ->latest()
            ->paginate(12);

        // ===== EVENT (CHỈ LẤY EVENT – KHÔNG is_active) =====
        $events = Event::latest()->take(3)->get();

        return view('shop.home.index', compact(
            'sections',
            'banners',
            'products',
            'events'
        ));
    }
}
