<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = ['name','price','category_id','description'];

    /* ================= RELATIONS ================= */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function totalStock()
    {
        return $this->variants->sum('quantity');
    }

    /* ================= CREATE ================= */

    public static function createProduct(array $data)
    {
        return DB::transaction(function () use ($data) {

            $product = self::create([
                'name'        => $data['name'],
                'price'       => $data['price'],
                'category_id' => $data['category_id'],
                'description' => $data['description'] ?? null,
            ]);

            // Ảnh sản phẩm
            if (!empty($data['images'])) {
                foreach ($data['images'] as $img) {
                    $path = $img->store('products', 'public');
                    $product->images()->create([
                        'image_path' => $path
                    ]);
                }
            }

            // Variants
            if (!empty($data['variants'])) {
                foreach ($data['variants'] as $v) {

                    $variant = $product->variants()->create([
                        'color'    => $v['color'] ?? null,
                        'size'     => $v['size'] ?? null,
                        'quantity' => $v['quantity'] ?? 0,
                    ]);

                    // Ảnh variant
                    if (!empty($v['images'])) {
                        foreach ($v['images'] as $img) {
                            $path = $img->store('variants', 'public');
                            $variant->images()->create([
                                'product_id' => $product->id,
                                'image_path' => $path
                            ]);
                        }
                    }
                }
            }

            return $product;
        });
    }

    /* ================= UPDATE ================= */

    public function updateProduct(array $data)
    {
        return DB::transaction(function () use ($data) {

            $this->update([
                'name'        => $data['name'],
                'price'       => $data['price'],
                'category_id' => $data['category_id'],
                'description' => $data['description'] ?? null,
            ]);

            // Thêm ảnh sản phẩm
            if (!empty($data['images'])) {
                foreach ($data['images'] as $img) {
                    $path = $img->store('products', 'public');
                    $this->images()->create([
                        'image_path' => $path
                    ]);
                }
            }

            // Update / create variants
            if (!empty($data['variants'])) {
                foreach ($data['variants'] as $v) {

                    if (!empty($v['id'])) {
                        $variant = $this->variants()->find($v['id']);
                        if (!$variant) continue;

                        $variant->update([
                            'color'    => $v['color'] ?? null,
                            'size'     => $v['size'] ?? null,
                            'quantity' => $v['quantity'] ?? 0,
                        ]);
                    } else {
                        $variant = $this->variants()->create([
                            'color'    => $v['color'] ?? null,
                            'size'     => $v['size'] ?? null,
                            'quantity' => $v['quantity'] ?? 0,
                        ]);
                    }

                    // Ảnh variant
                    if (!empty($v['images'])) {
                        foreach ($v['images'] as $img) {
                            $path = $img->store('variants', 'public');
                            $variant->images()->create([
                                'product_id' => $this->id,
                                'image_path' => $path
                            ]);
                        }
                    }
                }
            }

            return $this;
        });
    }

    /* ================= DELETE ================= */

    public function deleteProduct()
    {
        return DB::transaction(function () {

            foreach ($this->images as $img) {
                Storage::disk('public')->delete($img->image_path);
            }
            $this->images()->delete();

            foreach ($this->variants as $variant) {
                foreach ($variant->images as $img) {
                    Storage::disk('public')->delete($img->image_path);
                }
                $variant->images()->delete();
            }

            $this->variants()->delete();
            $this->delete();
        });
    }
}
