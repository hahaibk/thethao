<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function destroy(ProductImage $image)
    {
        // Xóa file ảnh
        Storage::disk('public')->delete($image->image_path);

        // Xóa record trong DB
        $image->delete();

        return back()->with('success', 'Xóa ảnh thành công');
    }
}
