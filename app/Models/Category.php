<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'has_color', 'has_size'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Tạo category mới
     *
     * @param array $data
     * @return Category
     */
    public static function createCategory(array $data)
    {
        return self::create([
            'name' => $data['name'],
            'has_color' => isset($data['has_color']) ? 1 : 0,
            'has_size'  => isset($data['has_size']) ? 1 : 0,
        ]);
    }

    /**
     * Cập nhật category
     *
     * @param array $data
     * @return bool
     */
    public function updateCategory(array $data)
    {
        $this->name = $data['name'];
        $this->has_color = isset($data['has_color']) ? 1 : 0;
        $this->has_size  = isset($data['has_size']) ? 1 : 0;

        return $this->save();
    }

    /**
     * Xóa category và sản phẩm liên quan (nếu muốn)
     *
     * @param bool $deleteProducts
     * @return bool|null
     */
    public function deleteCategory($deleteProducts = false)
    {
        if ($deleteProducts) {
            $this->products()->delete();
        }

        return $this->delete();
    }
}
