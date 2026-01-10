@extends('shop.layouts.app')

@section('title', $product->name ?? 'Chi tiết sản phẩm')

@section('content')

<div class="container my-5">
    <div class="row">
        {{-- ================== ẢNH SẢN PHẨM ================== --}}
        <div class="col-md-6">
            @php $firstImage = $product->images->first(); @endphp
            <div class="mb-2">
                <img id="mainProductImage" 
                     src="{{ $firstImage ? asset('storage/'.$firstImage->image_path) : 'https://via.placeholder.com/500x500' }}" 
                     class="img-fluid w-100" style="object-fit:cover; max-height:500px;">
            </div>
            @if($product->images->count() > 1)
            <div class="d-flex gap-2 overflow-auto">
                @foreach($product->images as $img)
                    <img src="{{ asset('storage/'.$img->image_path) }}" 
                         class="img-thumbnail" 
                         style="width:80px; cursor:pointer;" 
                         onclick="document.getElementById('mainProductImage').src='{{ asset('storage/'.$img->image_path) }}'">
                @endforeach
            </div>
            @endif
        </div>

        {{-- ================== THÔNG TIN SẢN PHẨM ================== --}}
        <div class="col-md-6">
            <h2>{{ $product->name ?? '' }}</h2>
            <h4 class="text-danger">{{ number_format($product->price ?? 0) }} đ</h4>

            {{-- Biến thể --}}
            @if($product->variants && count($product->variants))
                <form action="{{ route('cart.buy', $product->id) }}" method="POST">
                    @csrf
                    @foreach($product->variants as $i => $variant)
                        <div class="card mb-2 p-2">
                            @if($variant->color)
                                <div><strong>Màu:</strong> {{ $variant->color }}</div>
                            @endif
                            @if($variant->size)
                                <div><strong>Size:</strong> {{ $variant->size }}</div>
                            @endif
                            <div><strong>Số lượng còn:</strong> {{ $variant->quantity }}</div>
                            <div class="mt-1">
                                <label>Chọn số lượng:</label>
                                <input type="number" name="variants[{{ $variant->id }}]" min="1" max="{{ $variant->quantity }}" value="1" class="form-control" style="width:100px;">
                            </div>
                        </div>
                    @endforeach
                    <button type="submit" class="btn btn-primary mt-3">Thêm vào giỏ</button>
                </form>
            @else
                <p>Sản phẩm hiện chưa có biến thể.</p>
            @endif
        </div>
    </div>

    {{-- ================== MÔ TẢ SẢN PHẨM ================== --}}
    <div class="row mt-4">
        <div class="col-12">
            <h4>Mô tả sản phẩm</h4>
            <p>{{ $product->description ?? 'Chưa có mô tả cho sản phẩm này.' }}</p>
        </div>
    </div>
</div>

@endsection
