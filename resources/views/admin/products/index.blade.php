@extends('admin.layout')

@section('content')
<style>
    .page-title {
        font-size: 22px;
        font-weight: 700;
    }

    .card-admin {
        border-radius: 14px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,.08);
        overflow-x: auto;
    }

    .table {
        min-width: 1400px;
    }

    .table th {
        background: linear-gradient(90deg, #4f46e5, #6366f1);
        color: #fff;
        font-size: 12px;
        text-transform: uppercase;
        border: none;
        white-space: nowrap;
    }

    .table td {
        vertical-align: middle;
        background: #fff;
    }

    .badge-box {
        padding: 6px 12px;
        border-radius: 999px;
        font-weight: 600;
        font-size: 13px;
        display: inline-block;
        margin: 2px 4px 2px 0;
        white-space: nowrap;
    }

    .bg-color { background: #e0f2fe; color: #0369a1; }
    .bg-size  { background: #ecfeff; color: #0f766e; }
    .bg-stock { background: #dcfce7; color: #166534; }
    .bg-price { background: #fff7ed; color: #9a3412; }
</style>

{{-- HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="page-title">📦 Quản lý sản phẩm</div>

    <a href="{{ route('admin.products.create') }}"
       class="btn btn-primary btn-lg">
        ➕ Thêm sản phẩm
    </a>
</div>

{{-- TABLE --}}
<div class="card card-admin">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr class="text-center">
                    <th>ID</th>
                    <th class="text-start">Tên sản phẩm</th>
                    <th class="text-start">Variants (Màu / Size)</th>
                    <th>Tổng tồn</th>
                    <th>Giá gốc</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>
            @forelse($products as $product)
                <tr>
                    {{-- ID --}}
                    <td class="text-center fw-bold text-muted">
                        #{{ $product->id }}
                    </td>

                    {{-- NAME --}}
                    <td class="text-start">
                        <div class="fw-semibold">
                            {{ $product->name }}
                        </div>
                        <small class="text-muted">
                            {{ $product->category?->name }}
                        </small>
                    </td>

                    {{-- VARIANTS --}}
                    <td class="text-start">
                        @php
                            $grouped = $product->variants->groupBy('color');
                        @endphp

                        @foreach($grouped as $color => $variants)
                            <div class="mb-1">
                                <span class="badge-box bg-color">
                                    {{ $color ?? 'Không màu' }}
                                </span>

                                <span class="badge-box bg-size">
                                    {{ $variants->pluck('size')->unique()->implode(', ') }}
                                </span>
                            </div>
                        @endforeach
                    </td>

                    {{-- TOTAL STOCK --}}
                    <td class="text-center">
                        <span class="badge-box bg-stock">
                            {{ $product->total_stock }}
                        </span>
                    </td>

                    {{-- PRICE --}}
                    <td class="text-center">
                        <span class="badge-box bg-price">
                            {{ number_format($product->price) }} ₫
                        </span>
                    </td>

                    {{-- ACTION --}}
                    <td class="text-center">
                        <a href="{{ route('admin.products.show', $product) }}"
                           class="btn btn-sm btn-outline-secondary">
                            👁
                        </a>

                        <a href="{{ route('admin.products.edit', $product) }}"
                           class="btn btn-sm btn-outline-primary">
                            ✏
                        </a>

                        <form action="{{ route('admin.products.destroy', $product) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Xóa sản phẩm này?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                🗑
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="py-5 text-center text-muted">
                        Chưa có sản phẩm nào
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- PAGINATION --}}
<div class="mt-4 d-flex justify-content-center">
    {{ $products->links() }}
</div>
@endsection
