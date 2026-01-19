<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // ✅ thêm sport_id – KHÔNG bỏ cái cũ
    protected $fillable = ['name', 'has_color', 'has_size', 'sport_id'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // ✅ QUAN HỆ SPORT
    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    /**
     * Tạo category mới
     */
    public static function createCategory(array $data)
    {
        return self::create([
            'name'       => $data['name'],
            'sport_id'   => $data['sport_id'] ?? null,
            'has_color'  => isset($data['has_color']) ? 1 : 0,
            'has_size'   => isset($data['has_size']) ? 1 : 0,
        ]);
    }

    /**
     * Cập nhật category
     */
    public function updateCategory(array $data)
    {
        $this->name       = $data['name'];
        $this->sport_id   = $data['sport_id'] ?? null;
        $this->has_color  = isset($data['has_color']) ? 1 : 0;
        $this->has_size   = isset($data['has_size']) ? 1 : 0;

        return $this->save();
    }

    /**
     * Xóa category
     */
    public function deleteCategory($deleteProducts = false)
    {
        if ($deleteProducts) {
            $this->products()->delete();
        }

        return $this->delete();
    }
    
}
