@extends('admin.layout')

@section('content')
<div class="product-show">

    {{-- ===== THÔNG TIN CHUNG ===== --}}
    <div class="product-header">
        <div class="left">
            @php
                $mainImage = $product->images->first();
            @endphp

            <div class="main-image">
                @if($mainImage)
                    <img src="{{ asset('storage/'.$mainImage->image_path) }}" id="mainPreview">
                @else
                    <div class="no-image">No image</div>
                @endif
            </div>

            {{-- Gallery ảnh chung --}}
            <div class="gallery">
                @foreach($product->images as $img)
                    <img
                        src="{{ asset('storage/'.$img->image_path) }}"
                        onclick="document.getElementById('mainPreview').src=this.src"
                    >
                @endforeach
            </div>
        </div>

        <div class="right">
            <h1>{{ $product->name }}</h1>
            <p class="price">
                {{ number_format($product->price,0,',','.') }}₫
            </p>
            <p class="desc">{{ $product->description }}</p>
        </div>
    </div>

    {{-- ===== BIẾN THỂ ===== --}}
    <h2 class="variant-title">Biến thể theo màu</h2>

    <div class="variants">
        @foreach($product->variants as $variant)
            <div class="variant-card">

                <div class="variant-info">
                    <strong>Màu:</strong> {{ $variant->color }} <br>
                    <strong>Size:</strong> {{ $variant->size }} <br>
                    <strong>Tồn kho:</strong> {{ $variant->quantity }}
                </div>

                {{-- Ảnh theo màu --}}
                @if($variant->images->count())
                    <div class="variant-images">
                        @foreach($variant->images as $vimg)
                            <img
                                src="{{ asset('storage/'.$vimg->image_path) }}"
                                onclick="document.getElementById('mainPreview').src=this.src"
                            >
                        @endforeach
                    </div>
                @else
                    <div class="no-variant-image">Không có ảnh</div>
                @endif

            </div>
        @endforeach
    </div>

</div>

{{-- ===== CSS GỌN ĐẸP ===== --}}
<style>
.product-show {
    max-width: 1200px;
    margin: 20px auto;
    font-family: Arial, sans-serif;
}

.product-header {
    display: flex;
    gap: 30px;
    margin-bottom: 40px;
}

.main-image {
    width: 400px;
    height: 400px;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
}

.main-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-image {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #aaa;
}

.gallery {
    display: flex;
    gap: 8px;
    margin-top: 10px;
    flex-wrap: wrap;
}

.gallery img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border: 1px solid #ccc;
    border-radius: 6px;
    cursor: pointer;
}

.right h1 {
    margin: 0 0 10px;
}

.price {
    color: #e74c3c;
    font-size: 22px;
    margin-bottom: 10px;
}

.desc {
    color: #555;
}

.variant-title {
    margin-bottom: 15px;
}

.variants {
    display: grid;
    grid-template-columns: repeat(auto-fill,minmax(250px,1fr));
    gap: 20px;
}

.variant-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 12px;
    background: #fafafa;
}

.variant-info {
    margin-bottom: 10px;
    font-size: 14px;
}

.variant-images {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
}

.variant-images img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #ccc;
    cursor: pointer;
}

.no-variant-image {
    color: #aaa;
    font-size: 13px;
}
</style>
@endsection
