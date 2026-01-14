@extends('shop.layouts.app')

@section('title','Li-Ning Việt Nam')

@section('content')

{{-- ================== BANNER ================== --}}
@if(isset($sections) && count($sections))
<section class="home-banner py-3">
    <div id="homeBannerCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($sections as $k => $section)
                @if(!empty($section['image']))
                <div class="carousel-item {{ $k == 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/'.$section['image']) }}" 
                         class="d-block w-100" 
                         style="max-height:400px; object-fit:cover;">
                </div>
                @endif
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#homeBannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Trước</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#homeBannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Sau</span>
        </button>
    </div>
</section>
@else
<section class="home-section py-5 bg-light text-center">
    <p>Hiện chưa có banner nào.</p>
</section>
@endif

{{-- ================== DANH MỤC ================== --}}
@php
$categories = [
    ['name'=>'GIÀY NAM','image'=>'https://images.unsplash.com/photo-1542291026-7eec264c27ff'],
    ['name'=>'GIÀY NỮ','image'=>'https://images.unsplash.com/photo-1600180758890-6b94519a8ba6'],
    ['name'=>'ÁO QUẦN','image'=>'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a'],
    ['name'=>'PHỤ KIỆN','image'=>'https://images.unsplash.com/photo-1620799139834-6b8f844fbe61'],
];
@endphp

<section class="container my-5">
    <div class="row text-center">
        @foreach($categories as $cat)
            <div class="col-6 col-md-3 mb-4">
                <div class="category-box border rounded p-2">
                    <div style="height:150px; overflow:hidden; border-radius:8px;">
                        <img src="{{ $cat['image'] }}" class="img-fluid w-100" style="object-fit:cover; height:100%;">
                    </div>
                    <h6 class="mt-2">{{ $cat['name'] }}</h6>
                </div>
            </div>
        @endforeach
    </div>
</section>

{{-- ================== SẢN PHẨM NỔI BẬT ================== --}}
@if(isset($products) && count($products))
<section class="bg-light py-5">
    <div class="container">
        <h3 class="fw-bold mb-4">SẢN PHẨM NỔI BẬT</h3>
        <div class="row">
            @foreach($products as $product)
                @php
                    $firstImage = $product->images->first();
                @endphp
                <div class="col-6 col-md-3 mb-4">
                    <div class="product-card border rounded overflow-hidden">
                        <div style="height:250px; overflow:hidden;">
                            <img src="{{ $firstImage ? asset('storage/'.$firstImage->image_path) : 'https://via.placeholder.com/300x300' }}" 
                                 class="img-fluid w-100" style="object-fit:cover; height:100%;">
                        </div>
                        <div class="p-3 text-center">
                            <h6>{{ $product->name ?? '' }}</h6>
                            <div>{{ isset($product->price) ? number_format($product->price) : '' }} đ</div>
                            <a href="{{ route('products.show',$product->id) }}" class="btn btn-outline-dark w-100 mt-2">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@else
<section class="bg-light py-5 text-center">
    <p>Hiện chưa có sản phẩm nào.</p>
</section>
@endif
{{-- ================== EVENT ================== --}}
@if(isset($events) && $events->count())
<section class="py-5 bg-white">
    <div class="container">
        <h3 class="fw-bold mb-4 text-center">
            SỰ KIỆN 
        </h3>

        <div class="row">
            @foreach($events as $event)
                <div class="col-12 col-md-4 mb-4">
                    <a href="{{ route('events.show', $event->id) }}"
                       class="text-decoration-none text-dark">

                        <div class="card h-100 border-0 shadow-sm">

                            {{-- Ảnh --}}
                            <div style="height:220px; overflow:hidden;">
                                <img src="{{ $event->thumbnail
                                    ? asset('storage/'.$event->thumbnail)
                                    : 'https://via.placeholder.com/600x400' }}"
                                     class="w-100"
                                     style="height:100%; object-fit:cover;">
                            </div>

                            <div class="card-body">
                                <h5 class="fw-bold mb-1">
                                    {{ $event->title }}
                                </h5>

                                @if($event->subtitle)
                                    <p class="text-muted small mb-0">
                                        {{ $event->subtitle }}
                                    </p>
                                @endif
                            </div>

                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif


@endsection
