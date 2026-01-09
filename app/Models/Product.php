<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name','price','category_id','description'];

    // ===== RELATIONS =====
    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function variants() {
        return $this->hasMany(ProductVariant::class);
    }

    // 👉 ẢNH GALLERY CHUNG
    public function images() {
        return $this->hasMany(ProductImage::class);
    }

    // ===== TÍNH TOÁN =====
    public function totalStock(): int {
        return $this->variants()->sum('quantity');
    }

    // ===== CRUD LOGIC =====
    public static function createProduct(array $data)
    {
        $product = self::create([
            'name'        => $data['name'],
            'price'       => $data['price'],
            'category_id' => $data['category_id'],
            'description' => $data['description'] ?? null,
        ]);

        // ✅ LƯU ẢNH GALLERY
        if (!empty($data['images'])) {
            foreach ($data['images'] as $index => $img) {
                $path = $img->store('products', 'public');
                $product->images()->create([
                    'image_path' => $path,
                    'sort_order' => $index
                ]);
            }
        }

        // ✅ VARIANTS
        foreach ($data['variants'] as $variantData) {
            $product->addVariant($variantData);
        }

        return $product;
    }

    public function updateProduct(array $data)
    {
        $this->update($data);

        // 👉 THÊM ẢNH GALLERY MỚI (KHÔNG XOÁ CŨ)
        if (!empty($data['images'])) {
            foreach ($data['images'] as $index => $img) {
                $path = $img->store('products', 'public');
                $this->images()->create([
                    'image_path' => $path,
                    'sort_order' => $index
                ]);
            }
        }

        foreach ($data['variants'] as $variantData) {
            if (!empty($variantData['id'])) {
                $variant = $this->variants()->find($variantData['id']);
                $variant?->updateVariant($variantData);
            } else {
                $this->addVariant($variantData);
            }
        }

        return $this;
    }

    public function deleteProduct()
    {
        $this->variants()->delete();
        $this->images()->delete();
        $this->delete();
    }

    // ===== VARIANT =====
    public function addVariant(array $data)
    {
        $variant = $this->variants()->create([
            'color'    => $data['color'],
            'size'     => $data['size'],
            'quantity' => $data['quantity'],
            'price'    => $data['price'] ?? $this->price,
        ]);

        if (!empty($data['images'])) {
            foreach ($data['images'] as $img) {
                $variant->addImage($img);
            }
        }

        return $variant;
    }
}
