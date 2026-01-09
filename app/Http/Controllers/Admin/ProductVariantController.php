<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Storage;

class ProductVariantController extends Controller
{
    public function destroy(ProductVariant $variant)
    {
        // Xóa ảnh vật lý
        foreach ($variant->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        // Xóa variant (cascade sẽ xóa variant_images)
        $variant->delete();

        return back()->with('success', 'Đã xóa variant');
    }
}
