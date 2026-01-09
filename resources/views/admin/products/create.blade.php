@extends('admin.layouts.app')

@section('content')
<h1>Thêm sản phẩm</h1>

<form action="{{ route('admin.products.store') }}" 
      method="POST" 
      enctype="multipart/form-data">
    @csrf

    {{-- ================== PRODUCT INFO ================== --}}
    <div class="card mb-3">
        <div class="card-header">Thông tin sản phẩm</div>
        <div class="card-body">
            <div class="mb-3">
                <label>Tên sản phẩm *</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Mô tả</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
        </div>
    </div>

    {{-- ================== VARIANTS ================== --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <span>Variants</span>
            <button type="button" id="addVariant" class="btn btn-sm btn-primary">
                + Thêm variant
            </button>
        </div>

        <div class="card-body" id="variantWrapper">
            {{-- Variant mẫu --}}
        </div>
    </div>

    <button class="btn btn-success mt-3">Lưu sản phẩm</button>
</form>

{{-- ================== VARIANT TEMPLATE ================== --}}
<template id="variantTemplate">
    <div class="variant-item border p-3 mb-3">
        <div class="d-flex justify-content-between mb-2">
            <strong>Variant #<span class="variant-index"></span></strong>
            <button type="button" class="btn btn-sm btn-danger remove-variant">
                Xóa
            </button>
        </div>

        <div class="row">
            <div class="col-md-3">
                <label>Màu</label>
                <input type="text" class="form-control color">
            </div>

            <div class="col-md-3">
                <label>Size</label>
                <input type="text" class="form-control size">
            </div>

            <div class="col-md-3">
                <label>Giá *</label>
                <input type="number" class="form-control price" required>
            </div>

            <div class="col-md-3">
                <label>Số lượng *</label>
                <input type="number" class="form-control quantity" required>
            </div>
        </div>

        <div class="mt-3">
            <label>Ảnh variant * (chọn nhiều)</label>
            <input type="file" class="form-control images" multiple required>
        </div>
    </div>
</template>
@endsection
@push('scripts')
<script>
let variantIndex = 0;

const wrapper = document.getElementById('variantWrapper');
const template = document.getElementById('variantTemplate');

function addVariant() {
    const clone = template.content.cloneNode(true);

    clone.querySelector('.variant-index').innerText = variantIndex + 1;

    clone.querySelector('.color').name     = `variants[${variantIndex}][color]`;
    clone.querySelector('.size').name      = `variants[${variantIndex}][size]`;
    clone.querySelector('.price').name     = `variants[${variantIndex}][price]`;
    clone.querySelector('.quantity').name  = `variants[${variantIndex}][quantity]`;
    clone.querySelector('.images').name    = `variants[${variantIndex}][images][]`;

    clone.querySelector('.remove-variant').onclick = function () {
        this.closest('.variant-item').remove();
    };

    wrapper.appendChild(clone);
    variantIndex++;
}

// mặc định có 1 variant
addVariant();

document.getElementById('addVariant').addEventListener('click', addVariant);
</script>
@endpush
