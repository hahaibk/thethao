@extends('admin.layout')

@section('content')
<div class="product-index">
    <div class="page-header">
        <h1>Danh sách sản phẩm</h1>
        <a href="{{ route('admin.products.create') }}" class="btn-add">+ Thêm sản phẩm</a>
    </div>

    <table class="product-table">
        <thead>
            <tr>
                <th>Ảnh</th>
                <th>Tên</th>
                <th>Danh mục</th>
                <th>Giá</th>
                <th>Biến thể</th>
                <th>Tồn kho</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            @php
                $thumb = $product->images->first();
            @endphp
            <tr>
                <td>
                    <div class="thumb">
                        @if($thumb)
                            <img src="{{ asset('storage/'.$thumb->image_path) }}">
                        @else
                            —
                        @endif
                    </div>
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name ?? '—' }}</td>
                <td class="price">{{ number_format($product->price,0,',','.') }}₫</td>
                <td>{{ $product->variants_count ?? $product->variants->count() }}</td>
                <td>{{ $product->totalStock() }}</td>
                <td class="actions">
                    <a href="{{ route('admin.products.show',$product) }}" class="btn view">Xem</a>
                    <a href="{{ route('admin.products.edit',$product) }}" class="btn edit">Sửa</a>
                    <form action="{{ route('admin.products.destroy',$product) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn delete" onclick="return confirm('Xóa sản phẩm?')">Xóa</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $products->links() }}
</div>

<style>
.product-index{max-width:1200px;margin:20px auto;font-family:Arial}
.page-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:15px}
.btn-add{background:#2ecc71;color:#fff;padding:8px 14px;border-radius:6px;text-decoration:none}
.product-table{width:100%;border-collapse:collapse}
.product-table th,.product-table td{border:1px solid #ddd;padding:10px;text-align:center}
.thumb{width:70px;height:70px;border:1px solid #ddd;border-radius:8px;overflow:hidden;margin:auto}
.thumb img{width:100%;height:100%;object-fit:cover}
.price{color:#e74c3c;font-weight:bold}
.actions{display:flex;gap:6px;justify-content:center}
.btn{padding:5px 10px;border-radius:4px;border:none;cursor:pointer}
.btn.view{background:#3498db;color:#fff}
.btn.edit{background:#f1c40f}
.btn.delete{background:#e74c3c;color:#fff}
</style>
@endsection
