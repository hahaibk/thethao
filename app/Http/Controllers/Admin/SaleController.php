<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        return view('admin.home_sections.sales.index', [
            'sales' => Sale::list()
        ]);
    }

    public function create()
    {
        return view('admin.home_sections.sales.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:255',
            'subtitle'  => 'nullable|string|max:255',
            'content'   => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')
                ->store('sales', 'public');
        }

        Sale::storeData($data);

        return redirect()
            ->route('admin.homesection.sales.index')
            ->with('success', 'Thêm sale thành công');
    }

    public function edit(Sale $sale)
    {
        return view('admin.home_sections.sales.edit', compact('sale'));
    }

    public function update(Request $request, Sale $sale)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:255',
            'subtitle'  => 'nullable|string|max:255',
            'content'   => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')
                ->store('sales', 'public');
        }

        $sale->updateData($data);

        return redirect()
            ->route('admin.homesection.sales.index')
            ->with('success', 'Cập nhật sale thành công');
    }

    public function destroy(Sale $sale)
    {
        $sale->deleteData();

        return back()->with('success', 'Đã xóa sale');
    }
}
