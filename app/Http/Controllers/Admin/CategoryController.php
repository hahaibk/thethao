<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // 1. Danh sách
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    // 2. Form thêm mới
    public function create()
    {
        return view('admin.categories.create');
    }

    // 3. Xử lý THÊM (Gọi Model)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255',
        ], [
            'name.required' => 'Tên danh mục là bắt buộc',
            'name.unique'   => 'Tên danh mục đã tồn tại'
        ]);

        // GỌI MODEL XỬ LÝ
        Category::createCategory($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Thêm mới thành công!');
    }

    // 4. Form sửa
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // 5. Xử lý CẬP NHẬT (Gọi Model)
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories,name,'.$category->id,
        ]);

        // GỌI MODEL XỬ LÝ
        $category->updateCategory($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật thành công!');
    }

    // 6. Xử lý XÓA (Gọi Model)
    public function destroy(Category $category)
    {
        try {
            // GỌI MODEL XỬ LÝ
            $category->deleteCategory();
            return redirect()->route('admin.categories.index')->with('success', 'Xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}     