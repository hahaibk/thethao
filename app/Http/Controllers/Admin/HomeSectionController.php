<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeSection;
use Illuminate\Support\Facades\Storage;

class HomeSectionController extends Controller
{
    // Index danh sách banner
    public function index()
    {
        $banners = HomeSection::where('type','banner')->orderBy('sort_order')->get();
        return view('admin.home_sections.banner.index', compact('banners'));
    }

    // Form tạo mới banner
    public function create()
    {
        return view('admin.home_sections.banner.create');
    }

    // Lưu banner mới
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|max:2048',
            'sort_order' => 'nullable|integer',
        ]);

        $banner = new HomeSection();
        $banner->type = 'banner';
        $banner->title = $request->title;
        $banner->subtitle = $request->subtitle;
        $banner->link = $request->link;
        $banner->sort_order = $request->sort_order ?? 0;
        $banner->is_active = true;

        if ($request->hasFile('image')) {
            $banner->image = $request->file('image')->store('home_sections','public');
        }

        $banner->save();

        return redirect()->route('admin.homesection.banner.index')
                         ->with('success','Banner đã được thêm');
    }

    // Form sửa banner
    public function edit($id)
    {
        $banner = HomeSection::findOrFail($id);
        return view('admin.home_sections.banner.edit', compact('banner'));
    }

    // Cập nhật banner
    public function update(Request $request, $id)
    {
        $banner = HomeSection::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer',
        ]);

        $banner->title = $request->title;
        $banner->subtitle = $request->subtitle;
        $banner->link = $request->link;
        $banner->sort_order = $request->sort_order ?? 0;

        if ($request->hasFile('image')) {
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }
            $banner->image = $request->file('image')->store('home_sections','public');
        }

        $banner->save();

        return redirect()->route('admin.homesection.banner.index')
                         ->with('success','Banner đã được cập nhật');
    }

    // Xóa banner
    public function destroy($id)
    {
        $banner = HomeSection::findOrFail($id);
        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }
        $banner->delete();

        return redirect()->route('admin.homesection.banner.index')
                         ->with('success','Banner đã được xóa');
    }
}
