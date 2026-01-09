@extends('admin.layout')

@section('content')
<div class="product-edit">

    <h1>Cập nhật sản phẩm</h1>

    {{-- FORM CHÍNH --}}
    <form action="{{ route('admin.products.update', $product) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- ===== THÔNG TIN CHUNG ===== --}}
        <div class="box">
            <label>Tên sản phẩm</label>
            <input type="text" name="name"
                   value="{{ old('name', $product->name) }}" required>

            <label>Giá</label>
            <input type="number" name="price"
                   value="{{ old('price', $product->price) }}" required>

            <label>Danh mục</label>
            <select name="category_id" required>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}"
                        @selected($product->category_id == $cat->id)>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            <label>Mô tả</label>
            <textarea name="description">{{ old('description',$product->description) }}</textarea>
        </div>

        {{-- ===== ẢNH CHUNG ===== --}}
        <div class="box">
            <h3>Ảnh sản phẩm chung</h3>

            <input type="file" name="images[]" multiple>

            <div class="image-list">
                @foreach($product->images as $img)
                    <div class="img-box">
                        <img src="{{ asset('storage/'.$img->image_path) }}">
                        <button type="button"
                                onclick="deleteImage('{{ route('admin.product_images.destroy',$img) }}')">
                            ✕
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ===== BIẾN THỂ ===== --}}
        <div class="box">
            <h3>Biến thể theo màu / size</h3>

            @foreach($product->variants as $i => $variant)
                <div class="variant-card">

                    <input type="hidden"
                           name="variants[{{ $i }}][id]"
                           value="{{ $variant->id }}">

                    <div class="row">
                        <input type="text"
                               name="variants[{{ $i }}][color]"
                               value="{{ $variant->color }}"
                               placeholder="Màu" required>

                        <input type="text"
                               name="variants[{{ $i }}][size]"
                               value="{{ $variant->size }}"
                               placeholder="Size" required>

                        <input type="number"
                               name="variants[{{ $i }}][quantity]"
                               value="{{ $variant->quantity }}"
                               placeholder="Số lượng" required>
                    </div>

                    <label>Ảnh theo màu</label>
                    <input type="file"
                           name="variants[{{ $i }}][images][]"
                           multiple>

                    <div class="image-list">
                        @foreach($variant->images as $vimg)
                            <div class="img-box">
                                <img src="{{ asset('storage/'.$vimg->image_path) }}">
                                <button type="button"
                                        onclick="deleteImage('{{ route('admin.variant_images.destroy',$vimg) }}')">
                                    ✕
                                </button>
                            </div>
                        @endforeach
                    </div>

                </div>
            @endforeach
        </div>

        <button class="btn-save">💾 Lưu sản phẩm</button>
    </form>
</div>

{{-- ===== FORM XÓA ẨN (KHÔNG LỒNG FORM) ===== --}}
<form id="delete-form" method="POST" style="display:none">
    @csrf
    @method('DELETE')
</form>

<script>
function deleteImage(url) {
    if (!confirm('Xóa ảnh này?')) return;
    const form = document.getElementById('delete-form');
    form.action = url;
    form.submit();
}
</script>

{{-- ===== CSS GỌN GÀNG ===== --}}
<style>
.product-edit {
    max-width: 1100px;
    margin: 20px auto;
    font-family: Arial, sans-serif;
}

.box {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
    background: #fafafa;
}

.box label {
    display: block;
    font-weight: bold;
    margin-top: 10px;
}

.box input,
.box select,
.box textarea {
    width: 100%;
    padding: 8px;
    margin-top: 4px;
}

.image-list {
    display: flex;
    gap: 8px;
    margin-top: 10px;
    flex-wrap: wrap;
}

.img-box {
    position: relative;
}

.img-box img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #ccc;
}

.img-box button {
    position: absolute;
    top: -6px;
    right: -6px;
    border: none;
    background: #e74c3c;
    color: #fff;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    cursor: pointer;
}

.variant-card {
    border: 1px dashed #ccc;
    padding: 12px;
    margin-bottom: 15px;
    border-radius: 6px;
}

.row {
    display: flex;
    gap: 10px;
}

.row input {
    flex: 1;
}

.btn-save {
    background: #2ecc71;
    color: #fff;
    padding: 12px 20px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-size: 15px;
}
</style>
@endsection
