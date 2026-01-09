@extends('admin.layout')
@section('content')

<h3 class="fw-bold mb-4">
    {{ $product->id ? '✏ Sửa sản phẩm' : '➕ Tạo sản phẩm' }}
</h3>

<form method="POST"
      action="{{ $product->id ? route('admin.products.update', $product) : route('admin.products.store') }}"
      enctype="multipart/form-data"
      class="card shadow-sm p-4">
    @csrf
    @if($product->id) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" name="name"
                   value="{{ $product->name ?? '' }}" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Giá cơ bản</label>
            <input type="number" class="form-control" name="price"
                   value="{{ $product->price ?? '' }}" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Danh mục</label>
            <select class="form-select" name="category_id" required>
                <option value="">-- Chọn danh mục --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(($product->category_id ?? '') == $cat->id)>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-12">
            <label class="form-label">Mô tả</label>
            <textarea class="form-control" rows="3" name="description">{{ $product->description ?? '' }}</textarea>
        </div>
    </div>

    <hr class="my-4">

    <h5 class="fw-semibold mb-3">Variants</h5>

    <div class="variant-group">
        @foreach($product->variants ?? [] as $index => $v)
            @include('admin.products.variant_row', ['index' => $index, 'v' => $v])
        @endforeach
    </div>

    <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addVariant()">
        ➕ Thêm variant
    </button>

    <div class="mt-4">
        <button class="btn btn-success">💾 Lưu</button>
    </div>
</form>

<script>
let variantIndex = {{ count($product->variants ?? []) }};
function addVariant(){
    const container = document.querySelector('.variant-group');
    container.insertAdjacentHTML('beforeend', `
        <div class="card p-3 mb-3 border">
            <div class="row g-2">
                <div class="col-md-3">
                    <input class="form-control" name="variants[${variantIndex}][color]" placeholder="Màu" required>
                </div>
                <div class="col-md-3">
                    <input class="form-control" name="variants[${variantIndex}][size]" placeholder="Size" required>
                </div>
                <div class="col-md-3">
                    <input type="number" class="form-control" name="variants[${variantIndex}][quantity]" value="1" required>
                </div>
                <div class="col-md-3">
                    <input type="file" class="form-control" name="variants[${variantIndex}][images][]" multiple required>
                </div>
            </div>
        </div>
    `);
    variantIndex++;
}
</script>
@endsection
