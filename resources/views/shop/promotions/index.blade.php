@extends('shop.layouts.app')

@section('title','Sản phẩm khuyến mại')

@section('content')
<div class="container my-5">

    <h2 class="fw-bold mb-4 text-danger text-uppercase">
        🔥 SẢN PHẨM ĐANG KHUYẾN MẠI
    </h2>

    <div class="row">
        @forelse($products as $product)
            @php
                $img = $product->images->first();
                $promo = $product->activePromotion();
            @endphp

            <div class="col-6 col-md-3 mb-4">
                <div class="border rounded h-100 position-relative overflow-hidden">

                    {{-- BADGE SALE --}}
                    @if($promo)
                        <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                            SALE
                        </span>
                    @endif

                    <a href="{{ route('products.show',$product) }}">
                        <img
                            src="{{ $img ? asset('storage/'.$img->image_path) : 'https://via.placeholder.com/300' }}"
                            class="img-fluid w-100"
                            style="height:230px;object-fit:cover"
                        >
                    </a>

                    <div class="p-3 text-center">
                        <h6 class="mb-1">{{ $product->name }}</h6>

                        @if($promo)
                            <div>
                                <span class="text-danger fw-bold">
                                    {{ number_format($product->finalPrice()) }} đ
                                </span>
                                <del class="text-muted small">
                                    {{ number_format($product->price) }} đ
                                </del>
                            </div>
                        @else
                            <span class="fw-bold">
                                {{ number_format($product->price) }} đ
                            </span>
                        @endif

                        <a href="{{ route('products.show',$product) }}"
                           class="btn btn-outline-danger btn-sm mt-2 w-100">
                            Xem chi tiết
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Không có sản phẩm đang khuyến mại.</p>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>

</div>
@endsection
