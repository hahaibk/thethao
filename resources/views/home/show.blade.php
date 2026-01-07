<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>{{ $product->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/home/home.css') }}">
</head>
<body>

{{-- TOP BAR --}}
<div class="top_bar">
    <a href="{{ route('home') }}">
        <img src="{{ asset('images/logo.png') }}" alt="logo">
    </a>

    <div class="tab_sanpham">
        <button class="dropSP">Sản phẩm</button>
        <div class="dropdow-content">
            <a href="#">Cầu lông</a>
            <a href="#">Áo</a>
            <a href="#">Giày</a>
        </div>
    </div>

    @auth
        Xin chào {{ auth()->user()->name }}

        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin') }}">Admin</a>
        @endif

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button>Đăng xuất</button>
        </form>
    @else
        <a href="{{ route('login') }}">Đăng nhập</a>
        <a href="{{ route('register') }}">Đăng ký</a>
    @endauth
</div>

<h1>{{ $product->name }}</h1>
<p>Giá: {{ number_format($product->price) }} đ</p>

<h2>Biến thể</h2>
@foreach ($product->variants as $variant)
    <div style="border:1px solid #ccc; padding:10px; margin:10px">
        <p>Màu: {{ $variant['color'] }}</p>
        @if(isset($variant['size']))
            <p>Size: {{ $variant['size'] }}</p>
        @endif
        <p>Tồn kho: {{ $variant['stock'] }}</p>

        @auth
            <form method="POST" action="{{ route('cart.buy', $product) }}">
                @csrf
                <input type="hidden" name="color" value="{{ $variant['color'] }}">
                @if(isset($variant['size']))
                    <input type="hidden" name="size" value="{{ $variant['size'] }}">
                @endif
                <input type="number" name="qty" value="1" min="1" max="{{ $variant['stock'] }}">
                <button type="submit">Mua</button>
            </form>
        @endauth
    </div>
@endforeach

<a href="{{ route('home') }}">Quay lại</a>

</body>
</html>
