@extends('admin.layout')

@section('content')


<h2 style="margin:20px 0;">Danh sách sản phẩm</h2>

<a href="{{ route('admin.products.create') }}"
   style="
        display:inline-block;
        margin-bottom:15px;
        padding:8px 12px;
        background:#2563eb;
        color:#fff;
        text-decoration:none;
        border-radius:6px;
   ">
    ➕ Thêm sản phẩm
</a>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<table style="width:100%;border-collapse:collapse;background:#fff;">
    <thead>
        <tr style="background:#f3f4f6;">
            <th>ID</th>
            <th>Tên</th>
            <th>Giá</th>
            <th>Danh mục</th>
            <th>Ảnh</th>
            <th>Tổng tồn</th>
            <th>Hành động</th>
        </tr>
    </thead>

    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ number_format($product->price) }} đ</td>
            <td>{{ $product->category->name ?? '-' }}</td>
            <td>
                @if($product->variants[0]['image'] ?? false)
                    <img src="{{ asset('storage/'.$product->variants[0]['image']) }}"
                         style="max-width:70px;">
                @endif
            </td>
            <td><strong>{{ $product->totalStock() }}</strong></td>
            <td>
                <a href="{{ route('admin.products.show', $product) }}">👁</a>
                <a href="{{ route('admin.products.edit', $product) }}">✏</a>

                <form action="{{ route('admin.products.destroy', $product) }}"
                      method="POST"
                      style="display:inline"
                      onsubmit="return confirm('Xóa sản phẩm này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">🗑</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top:20px;">
    {{ $products->links() }}
</div>

@endsection
