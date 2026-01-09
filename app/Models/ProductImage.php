<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',    // Ảnh chung cho sản phẩm
        'variant_id',    // Ảnh riêng cho biến thể (nếu có)
        'image_path',
        'is_main',       // Ảnh chính
        'sort_order'
    ];

    // Ảnh thuộc sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Ảnh thuộc biến thể
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}
