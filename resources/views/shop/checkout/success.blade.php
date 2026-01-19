@extends('shop.layouts.app')

@section('title','Thanh toán thành công')

@section('content')
<div class="container my-5 text-center">

    <div class="card p-5 shadow-sm">

        <div class="mb-4">
            <span style="font-size:60px">✅</span>
        </div>

        <h2 class="text-success fw-bold mb-3">
            Thanh toán thành công!
        </h2>

        <p class="text-muted mb-4">
            Đơn hàng của bạn đã được ghi nhận.<br>
            Cảm ơn bạn đã mua sắm tại <b>LI-NING STORE</b> ❤️
        </p>

        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('home') }}" class="btn btn-danger px-4">
                🏠 Về trang chủ
            </a>

            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary px-4">
                🛒 Tiếp tục mua sắm
            </a>
        </div>

    </div>

</div>
@endsection
