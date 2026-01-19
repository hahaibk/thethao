<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SportController extends Controller
{
    /**
     * Danh sách môn thể thao
     */
    public function index()
    {
        // ⚠️ KHÔNG dùng latest nữa
        // Hiển thị theo sort_order trước, rồi đến id
        $sports = Sport::orderBy('sort_order')
                       ->orderBy('id')
                       ->paginate(10);

        return view('admin.sports.index', compact('sports'));
    }

    /**
     * Form tạo
     */
    public function create()
    {
        return view('admin.sports.create');
    }

    /**
     * Lưu mới
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'image'      => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer',
        ]);

        // default sort_order nếu không nhập
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sports', 'public');
        }

        Sport::create($data);

        return redirect()->route('admin.sports.index')
            ->with('success', 'Thêm môn thể thao thành công');
    }

    /**
     * Form sửa
     */
    public function edit(Sport $sport)
    {
        return view('admin.sports.edit', compact('sport'));
    }

    /**
     * Cập nhật
     */
    public function update(Request $request, Sport $sport)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'image'      => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer',
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            // xoá ảnh cũ
            if ($sport->image) {
                Storage::disk('public')->delete($sport->image);
            }

            $data['image'] = $request->file('image')->store('sports', 'public');
        }

        $sport->update($data);

        return redirect()->route('admin.sports.index')
            ->with('success', 'Cập nhật thành công');
    }

    /**
     * Xoá
     */
    public function destroy(Sport $sport)
    {
        if ($sport->image) {
            Storage::disk('public')->delete($sport->image);
        }

        $sport->delete();

        return redirect()->back()
            ->with('success', 'Đã xóa môn thể thao');
    }
       
}
