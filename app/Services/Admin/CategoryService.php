<?php
namespace App\Services\Admin;

use App\Models\Category;

class CategoryService
{
    public function create(array $data): Category
    {
        return Category::create([
            'name'      => $data['name'],
            'has_size'  => $data['has_size'] ?? false,
            'has_color' => $data['has_color'] ?? false,
        ]);
    }

    public function update(Category $category, array $data): Category
    {
        $category->update([
            'name'      => $data['name'],
            'has_size'  => $data['has_size'] ?? false,
            'has_color' => $data['has_color'] ?? false,
        ]);

        return $category;
    }
}

