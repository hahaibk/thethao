<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $table = 'product_variants';

    protected $fillable = [
        'product_id',
        'color',
        'size',
        'quantity',
        'price'
    ];

    /**
     * Variant thuộc về sản phẩm
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Ảnh của biến thể (BẢNG RIÊNG)
     */
    public function images()
        {
            return $this->hasMany(VariantImage::class, 'variant_id');
        }
     // Giá gốc (variant ưu tiên, không có thì lấy product)
    /* ================= PRICE LOGIC ================= */

    public function getBasePriceAttribute()
    {
        return $this->price ?? $this->product->price;
    }

    public function getFinalPriceAttribute()
    {
        $price = $this->base_price;

        if ($promotion = $this->product->activePromotion()) {
            return $promotion->apply($price);
        }

        return $price;
    }

    // GIÁ CUỐI CÙNG CỦA VARIANT
    public function finalPrice()
    {
        $price = $this->price ?? $this->product->price;

        $promotion = $this->product->activePromotion();

        if ($promotion) {
            return $promotion->apply($price);
        }

        return $price;
    }
}
