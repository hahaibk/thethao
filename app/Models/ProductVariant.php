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
}
