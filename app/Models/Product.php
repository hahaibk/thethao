<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = ['name','price','category_id','description'];

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

            // Ảnh chung
            if (!empty($data['images'])) {
                foreach ($data['images'] as $img) {
                    $path = $img->store('products', 'public');
                    $product->images()->create([
                        'image_path' => $path
                    ]);
                }
            }

            // Variant + ảnh variant
            if(!empty($data['variants'])){
                foreach ($data['variants'] as $v) {
                    $variant = $product->variants()->create([
                        'color'    => $v['color'] ?? null,
                        'size'     => $v['size'] ?? null,
                        'quantity' => $v['quantity'] ?? 0,
                        'price'    => $v['price'] ?? null,
                    ]);

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

            // thêm ảnh chung
            if (!empty($data['images'])) {
                foreach ($data['images'] as $img) {
                    $path = $img->store('products', 'public');
                    $this->images()->create([
                        'image_path' => $path
                    ]);
                }
            }

            // Cập nhật variant
            if(!empty($data['variants'])){
                foreach ($data['variants'] as $v) {
                    $variant = !empty($v['id'])
                        ? $this->variants()->find($v['id'])
                        : $this->variants()->create([
                            'color'    => $v['color'] ?? null,
                            'size'     => $v['size'] ?? null,
                            'quantity' => $v['quantity'] ?? 0,
                            'price'    => $v['price'] ?? null,
                        ]);

                    if(!$variant) continue;

                    $variant->update([
                        'color'    => $v['color'] ?? null,
                        'size'     => $v['size'] ?? null,
                        'quantity' => $v['quantity'] ?? 0,
                        'price'    => $v['price'] ?? null,
                    ]);

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
