@extends('admin.layout')

@section('content')
<h2>{{ $product->name }}</h2>
<p>Giá: {{ number_format($product->price) }} đ</p>
<p>Loại: {{ $product->category->name }}</p>

<hr>

<h3>Kho hàng</h3>

@forelse($product->colors as $color)
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px">
        <b>Màu:</b> {{ $color->color ?? 'Mặc định' }} <br>

        @if($color->image)
            <img src="{{ asset('storage/'.$color->image) }}" width="120">
        @endif

        <ul>
            @foreach($color->sizes as $size)
                <li>
                    Size {{ $size->size ?? 'FREE' }} :
                    {{ $size->quantity }}
                </li>
            @endforeach
        </ul>
    </div>
@empty
    <p>Chưa có hàng trong kho</p>
@endforelse

<hr>

<h3>Nhập kho (thêm size / màu)</h3>

<form method="POST"
      enctype="multipart/form-data"
      action="{{ route('admin.products.variant.store', $product) }}">
    @csrf

    {{-- MÀU --}}
    @if($product->category->has_color)
        <div>
            <label>Màu</label>
            <input type="text" name="color" placeholder="VD: Đỏ, Đen">
        </div>

        <div>
            <label>Ảnh theo màu</label>
            <input type="file" name="image">
        </div>
    @endif

    {{-- SIZE --}}
    @if($product->category->has_size)
        <div>
            <label>Size</label>
            <select name="size">
                <option value="S">S</option>
                <option value="M">M</option>
                <option value="L">L</option>
                <option value="XL">XL</option>
            </select>
        </div>
    @endif

    {{-- SỐ LƯỢNG --}}
    <div>
        <label>Số lượng</label>
        <input type="number" name="quantity" min="1" required>
    </div>

    <br>
    <button type="submit">Nhập kho</button>
</form>
@endsection
