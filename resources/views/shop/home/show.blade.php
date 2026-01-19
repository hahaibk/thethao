@extends('shop.layouts.app')

@section('title', $product->name ?? 'Chi tiết sản phẩm')

@section('content')

@php
    $promo = $product->activePromotion();
@endphp

<div class="container my-5">
    <div class="row">

        {{-- ================== ẢNH ================== --}}
        <div class="col-md-6">
            @php $firstImage = $product->images->first(); @endphp

            <div class="mb-3 border rounded">
                <img id="mainProductImage"
                     src="{{ $firstImage ? asset('storage/'.$firstImage->image_path) : 'https://via.placeholder.com/500x500' }}"
                     class="img-fluid w-100"
                     style="object-fit:cover; max-height:500px;">
            </div>

            @if($product->images->count() > 1)
                <div class="d-flex gap-2 overflow-auto">
                    @foreach($product->images as $img)
                        <img
                            src="{{ asset('storage/'.$img->image_path) }}"
                            class="img-thumbnail"
                            style="width:80px; cursor:pointer;"
                            onclick="document.getElementById('mainProductImage').src='{{ asset('storage/'.$img->image_path) }}'"
                        >
                    @endforeach
                </div>
            @endif
        </div>

        {{-- ================== THÔNG TIN ================== --}}
        <div class="col-md-6">
            <h2 class="fw-bold mb-2">{{ $product->name }}</h2>

            {{-- GIÁ --}}
            <div class="mb-3">
                @if($promo)
                    <h4 class="text-danger fw-bold mb-0">
                        {{ number_format($product->finalPrice()) }} đ
                    </h4>
                    <del class="text-muted">
                        {{ number_format($product->price) }} đ
                    </del>
                @else
                    <h4 class="fw-bold text-dark">
                        {{ number_format($product->price) }} đ
                    </h4>
                @endif
            </div>

            {{-- ================== VARIANTS ================== --}}
            @if($product->variants && $product->variants->count())
            <form id="buyForm" action="{{ route('cart.buy', $product->id) }}" method="POST">
                @csrf

                @foreach($product->variants as $variant)
                    <div class="card mb-3 p-3 {{ $variant->quantity == 0 ? 'opacity-50' : '' }}">

                        @if($variant->color)
                            <div><strong>Màu:</strong> {{ $variant->color }}</div>
                        @endif

                        @if($variant->size)
                            <div><strong>Size:</strong> {{ $variant->size }}</div>
                        @endif

                        <div class="mb-1">
                            <strong>Giá:</strong>
                            <span class="text-danger fw-bold">
                                {{ number_format($variant->finalPrice()) }} đ
                            </span>
                        </div>

                        <div class="mb-2">
                            <strong>Tình trạng:</strong>
                            @if($variant->quantity > 0)
                                <span class="text-success">
                                    Còn {{ $variant->quantity }} sản phẩm
                                </span>
                            @else
                                <span class="text-danger fw-bold">
                                    Hết hàng
                                </span>
                            @endif
                        </div>

                        @if($variant->quantity > 0)
                            <div>
                                <label class="form-label">Số lượng</label>
                                <input
                                    type="number"
                                    name="variants[{{ $variant->id }}]"
                                    class="form-control quantity-input"
                                    min="1"
                                    max="{{ $variant->quantity }}"
                                    value="1"
                                    data-max="{{ $variant->quantity }}"
                                    style="width:120px"
                                >
                            </div>
                        @endif
                    </div>
                @endforeach

                {{-- NÚT --}}
                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn btn-outline-dark px-4">
                        🛒 Thêm vào giỏ
                    </button>

                    <button type="button" class="btn btn-danger px-4" onclick="buyNow()">
                        ⚡ Mua ngay
                    </button>
                </div>
            </form>
            @else
                <p class="text-muted">Sản phẩm chưa có biến thể.</p>
            @endif
        </div>
    </div>

    {{-- ================== MÔ TẢ ================== --}}
    <div class="row mt-5">
        <div class="col-12">
            <h4 class="fw-bold">Mô tả sản phẩm</h4>
            <p class="text-muted">
                {{ $product->description ?? 'Chưa có mô tả cho sản phẩm này.' }}
            </p>
        </div>
    </div>
</div>

{{-- ================== SCRIPT ================== --}}
<script>
document.querySelectorAll('.quantity-input').forEach(input => {
    input.addEventListener('input', function () {
        let max = parseInt(this.dataset.max);
        let val = parseInt(this.value);

        if (val > max) this.value = max;
        if (val < 1 || isNaN(val)) this.value = 1;
    });
});

function buyNow() {
    let form = document.getElementById('buyForm');

    let input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'buy_now';
    input.value = 1;

    form.appendChild(input);
    form.submit();
}
</script>

@endsection
