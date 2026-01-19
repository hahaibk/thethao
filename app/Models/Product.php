<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'category_id',
         'sport_id', 
        'gender', 
        'description',
        'is_featured',
    ];
     public function sport()
    {
        return $this->belongsTo(Sport::class);
    }
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

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class);
    }

    /* ================= STOCK ================= */

    public function totalStock()
    {
        return $this->variants->sum('quantity');
    }
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('admin.products.show', compact('product'));
    }

    /* ================= PROMOTION LOGIC ================= */

    // Lấy khuyến mãi đang áp dụng (ưu tiên giá trị cao nhất)
    public function activePromotion()
    {
        return $this->promotions
            ->filter(fn ($promo) => $promo->isValid())
            ->sortByDesc('value')
            ->first();
    }

    // GIÁ SAU KHI GIẢM
    public function finalPrice()
    {
        $price = $this->price;

        $promotion = $this->activePromotion();

        if ($promotion) {
            return $promotion->apply($price);
        }

        return $price;
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

            if (!empty($data['images'])) {
                foreach ($data['images'] as $img) {
                    $path = $img->store('products', 'public');
                    $this->images()->create([
                        'image_path' => $path
                    ]);
                }
            }

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
            $this->variants()->delete();
            $this->delete();
        });
    }

    /* ================= SCOPE ================= */

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', 1);
    }
}
