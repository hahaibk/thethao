<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // Hiển thị danh sách category
    public function index()
    {
        $categories = Category::paginate(10); // phân trang 10 item
        return view('admin.categories.index', compact('categories'));
    }

    // Form tạo category
    public function create()
    {
        return view('admin.categories.create');
    }

    // Lưu category mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::createCategory($request->all());

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category tạo thành công!');
    }

    // Hiển thị chi tiết category
    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    // Form sửa category
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // Cập nhật category
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->updateCategory($request->all());

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category cập nhật thành công!');
    }

    // Xóa category
    public function destroy(Category $category)
    {
        $category->deleteCategory(true); // true nếu muốn xóa luôn sản phẩm liên quan

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category xóa thành công!');
    }
}
