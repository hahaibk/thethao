@extends('shop.layouts.app')

@section('title','Li-Ning Việt Nam')

@section('content')

<style>
/* ================= BANNER ================= */
.home-banner{
    padding:0 !important;
}
.home-banner .carousel,
.home-banner .carousel-inner,
.home-banner .carousel-item{
    height:520px;
}
.home-banner-img{
    width:100%;
    height:100%;
    object-fit:cover;
}

/* ================= SPORT SLIDER ================= */
.sport-section{
    overflow:hidden;
}
.sport-slider-wrapper{
    position:relative;
    width:100%;
}
.sport-slider{
    display:flex;
    flex-wrap:nowrap;
    gap:20px;
    overflow-x:auto;
    scroll-behavior:smooth;
    padding:10px 60px;
}
.sport-slider::-webkit-scrollbar{
    display:none;
}
.sport-item{
    flex:0 0 280px;
    height:420px;
    border-radius:22px;
    overflow:hidden;
    position:relative;
    background:#000;
}
.sport-item img{
    width:100%;
    height:100%;
    object-fit:cover;
    transition:transform .4s ease;
}
.sport-item:hover img{
    transform:scale(1.05);
}
.sport-title{
    position:absolute;
    bottom:0;
    left:0;
    width:100%;
    padding:14px 0;
    text-align:center;
    color:#fff;
    font-weight:700;
    font-size:14px;
    letter-spacing:1px;
    background:linear-gradient(to top, rgba(0,0,0,.7), rgba(0,0,0,0));
}
.sport-nav{
    position:absolute;
    top:50%;
    transform:translateY(-50%);
    width:46px;
    height:46px;
    border-radius:50%;
    border:none;
    background:#fff;
    box-shadow:0 6px 16px rgba(0,0,0,.2);
    font-size:30px;
    cursor:pointer;
    z-index:10;
}
.sport-nav.prev{ left:10px; }
.sport-nav.next{ right:10px; }
</style>

{{-- ================== BANNER ================== --}}
@if(isset($sections) && count($sections))
<section class="home-banner">
    <div id="homeBannerCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($sections as $k => $section)
                @if(!empty($section['image']))
                <div class="carousel-item {{ $k == 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/'.$section['image']) }}"
                         class="home-banner-img">
                </div>
                @endif
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button"
                data-bs-target="#homeBannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button"
                data-bs-target="#homeBannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</section>
@endif

{{-- ================== SPORT SLIDER ================== --}}
<section class="sport-section my-5">
    <div class="container position-relative">
        <h3 class="text-center mb-4 fw-bold">MÔN THỂ THAO</h3>

        <div class="sport-slider-wrapper">
            <button class="sport-nav prev" onclick="slideSport(-1)">‹</button>

            <div class="sport-slider" id="sportSlider">
                @foreach($sports as $sport)
                    <div class="sport-item">
                        <img src="{{ $sport->image
                            ? asset('storage/'.$sport->image)
                            : 'https://via.placeholder.com/400x550' }}">
                        <div class="sport-title">{{ $sport->name }}</div>
                    </div>
                @endforeach
            </div>

            <button class="sport-nav next" onclick="slideSport(1)">›</button>
        </div>
    </div>
</section>

{{-- ================== SẢN PHẨM NỔI BẬT ================== --}}
<section class="bg-light py-5">
    <div class="container">
        <h3 class="fw-bold mb-4">⭐ SẢN PHẨM NỔI BẬT</h3>

        <div class="row">
            @forelse($products as $product)
                @php
                    $product->loadMissing('promotions');
                    $img = $product->images->first();
                    $promo = $product->activePromotion();
                @endphp

                <div class="col-6 col-md-3 mb-4">
                    <div class="border rounded overflow-hidden h-100 position-relative">
                        @if($promo)
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                -{{ $promo->type === 'percent' ? $promo->value.'%' : number_format($promo->value).'đ' }}
                            </span>
                        @endif

                        <div style="height:250px;overflow:hidden;">
                            <img src="{{ $img ? asset('storage/'.$img->image_path) : 'https://via.placeholder.com/300' }}"
                                 class="w-100 h-100" style="object-fit:cover">
                        </div>

                        <div class="p-3 text-center">
                            <h6>{{ $product->name }}</h6>
                            <div class="mb-2">
                                @if($promo && $product->finalPrice() < $product->price)
                                    <span class="text-danger fw-bold">{{ number_format($product->finalPrice()) }} đ</span>
                                    <del class="small text-muted">{{ number_format($product->price) }} đ</del>
                                @else
                                    <span class="fw-bold">{{ number_format($product->price) }} đ</span>
                                @endif
                            </div>
                            <a href="{{ route('products.show',$product) }}"
                               class="btn btn-outline-dark w-100">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">Chưa có sản phẩm</p>
            @endforelse
        </div>
    </div>
</section>

<script>
function slideSport(direction){
    const slider = document.getElementById('sportSlider');
    slider.scrollLeft += direction * 320;
}
</script>

@endsection
