<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang chủ</title>
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
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button>Đăng xuất</button>
        </form>
    @else
        <a href="{{ route('login') }}">Đăng nhập</a>
        <a href="{{ route('register') }}">Đăng ký</a>
    @endauth
</div>

{{-- BANNER --}}
<div class="banner">
    <img src="{{ asset('images/banner1.png') }}" alt="">
</div>

@foreach ($products as $item)
    <div style="border:1px solid #ccc; padding:10px; margin:10px">
        <h3>{{ $item->name }}</h3>

        <p>
            Giá:
            {{ number_format($item->price) }} đ
        </p>

        

        <a href="{{ route('products.show', $item) }}">
            Xem chi tiết
        </a>
    </div>
@endforeach

{{ $products->links() }}

</body>
</html>
