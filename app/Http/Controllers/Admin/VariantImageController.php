<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VariantImage;
use Illuminate\Support\Facades\Storage;

class VariantImageController extends Controller
{
    public function destroy(VariantImage $variantImage)
    {
        if ($variantImage->image_path &&
            Storage::disk('public')->exists($variantImage->image_path)) {
            Storage::disk('public')->delete($variantImage->image_path);
        }

        $variantImage->delete();

        return back()->with('success', 'Đã xóa ảnh biến thể');
    }
}
