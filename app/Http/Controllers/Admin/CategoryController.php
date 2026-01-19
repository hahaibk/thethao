<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Sport;

class CategoryController extends Controller
{
    // Hiển thị danh sách category
    public function index()
    {
        $categories = Category::with('sport')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    // Form tạo category
    public function create()
    {
        $sports = Sport::all();
        return view('admin.categories.create', compact('sports'));
    }

    // Lưu category mới
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'sport_id'  => 'nullable|exists:sports,id',
            'has_size'  => 'boolean',
            'has_color' => 'boolean',
        ]);

        Category::createCategory([
            'name'      => $data['name'],
            'sport_id'  => $data['sport_id'] ?? null,
            'has_size'  => $data['has_size'] ?? 0,
            'has_color' => $data['has_color'] ?? 0,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category tạo thành công!');
    }

    // Hiển thị chi tiết category
    public function show(Category $category)
    {
        $category->load('sport');
        return view('admin.categories.show', compact('category'));
    }

    // Form sửa category
    public function edit(Category $category)
    {
        $sports = Sport::all();
        return view('admin.categories.edit', compact('category', 'sports'));
    }

    // Cập nhật category
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'sport_id'  => 'nullable|exists:sports,id',
            'has_size'  => 'boolean',
            'has_color' => 'boolean',
        ]);

        $category->updateCategory([
            'name'      => $data['name'],
            'sport_id'  => $data['sport_id'] ?? null,
            'has_size'  => $data['has_size'] ?? 0,
            'has_color' => $data['has_color'] ?? 0,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category cập nhật thành công!');
    }

    // Xóa category
    public function destroy(Category $category)
    {
        $category->deleteCategory(true);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category xóa thành công!');
    }
}
