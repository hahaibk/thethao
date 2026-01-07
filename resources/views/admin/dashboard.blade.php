@extends('admin.layout')

@section('content')

<h2 style="margin-bottom:10px;">📊 Dashboard</h2>

{{-- LINK NHANH --}}
<div style="margin-bottom:25px;">
    <a href="{{ route('admin.products.index') }}"
       style="
            display:inline-block;
            padding:10px 15px;
            background:#2563eb;
            color:#fff;
            border-radius:6px;
            text-decoration:none;
            margin-right:10px;
       ">
        👕 Quản lý sản phẩm
    </a>

    <a href="{{ route('admin.categories.index') }}"
       style="
            display:inline-block;
            padding:10px 15px;
            background:#16a34a;
            color:#fff;
            border-radius:6px;
            text-decoration:none;
       ">
        📂 Quản lý loại
    </a>
</div>

{{-- THỐNG KÊ --}}
<div style="
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap:20px;
">

    <div class="card">
        <h4>Sản phẩm</h4>
        <p style="font-size:28px;font-weight:bold;">{{ $totalProducts }}</p>
    </div>

    <div class="card">
        <h4>Danh mục</h4>
        <p style="font-size:28px;font-weight:bold;">{{ $totalCategories }}</p>
    </div>

    <div class="card">
        <h4>Người dùng</h4>
        <p style="font-size:28px;font-weight:bold;">{{ $totalUsers }}</p>
    </div>

    <div class="card">
        <h4>Tồn kho</h4>
        <p style="font-size:28px;font-weight:bold;color:#16a34a;">
            {{ $totalStock }}
        </p>
    </div>

</div>

@endsection
