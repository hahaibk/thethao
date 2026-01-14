<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeSectionController extends Controller
{
    public function index()
    {
        $banners = HomeSection::where('type', 'banner')
            ->orderBy('sort_order')
            ->get();

        return view('admin.home_sections.banner.index', compact('banners'));
    }

    public function create()
    {
        $banner = new HomeSection();

        return view('admin.home_sections.banner.create', compact('banner'));
    }

    public function edit($id)
    {
        $banner = HomeSection::findOrFail($id);

        return view('admin.home_sections.banner.edit', compact('banner'));
    }

    public function store(Request $request)
    {
        return $this->persist(new HomeSection(), $request);
    }

    public function save(Request $request, $id)
    {
        $banner = HomeSection::findOrFail($id);

        return $this->persist($banner, $request);
    }

    private function persist(HomeSection $banner, Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => $banner->exists ? 'nullable|image|max:2048' : 'required|image|max:2048',
            'sort_order' => 'nullable|integer',
        ]);

        $banner->type = 'banner';
        $banner->title = $request->title;
        $banner->subtitle = $request->subtitle;
        $banner->link = $request->link;
        $banner->sort_order = $request->sort_order ?? 0;
        $banner->is_active = true;

        if ($request->hasFile('image')) {
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }

            $banner->image = $request->file('image')->store('home_sections', 'public');
        }

        $banner->save();

        return redirect()
            ->route('admin.homesection.banner.index')
            ->with('success', 'Lưu banner thành công');
    }

    public function destroy($id)
    {
        $banner = HomeSection::findOrFail($id);

        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return redirect()
            ->route('admin.homesection.banner.index')
            ->with('success', 'Đã xóa banner');
    }
}
