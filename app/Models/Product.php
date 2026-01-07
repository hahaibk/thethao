<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'category_id',
        'variants'
    ];

    protected $casts = [
        'variants' => 'array'
    ];

    /* =====================
        RELATION
    ====================== */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /* =====================
        BUSINESS LOGIC
    ====================== */

    // Tạo sản phẩm với biến thể đầu tiên
    public static function createWithVariant(array $data)
    {
        return self::create([
            'name'        => $data['name'],
            'price'       => $data['price'],
            'category_id' => $data['category_id'],
            'variants'    => [$data['variant']]
        ]);
    }

    // Thêm hoặc cộng dồn biến thể (size + màu)
    public function addOrUpdateVariant(array $newVariant)
    {
        $variants = $this->variants ?? [];

        foreach ($variants as &$variant) {
            if (
                ($variant['size'] ?? null)  === ($newVariant['size'] ?? null) &&
                ($variant['color'] ?? null) === ($newVariant['color'] ?? null)
            ) {
                $variant['quantity'] += $newVariant['quantity'];
                $this->update(['variants' => $variants]);
                return;
            }
        }

        $variants[] = $newVariant;
        $this->update(['variants' => $variants]);
    }

    /* =====================
        DASHBOARD
    ====================== */

    // ✅ HÀM BẠN ĐANG THIẾU
    public function totalStock(): int
    {
        return collect($this->variants ?? [])
            ->sum(fn ($variant) => $variant['quantity'] ?? 0);
    }
}
