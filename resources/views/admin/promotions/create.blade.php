@extends('admin.layout')

@section('page-title', 'Tạo khuyến mãi')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-danger text-white fw-bold">
            Tạo khuyến mãi mới
        </div>

        <form method="POST" action="{{ route('admin.promotions.store') }}">
            @csrf

            <div class="card-body row g-3">

                {{-- Tên --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tên khuyến mãi</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name') }}"
                           required>
                </div>

                {{-- Loại --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Loại giảm</label>
                    <select name="type" class="form-select">
                        <option value="percent">Phần trăm (%)</option>
                        <option value="fixed">Giá cố định (đ)</option>
                    </select>
                </div>

                {{-- Giá trị --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Giá trị</label>
                    <input type="number"
                           name="value"
                           class="form-control"
                           value="{{ old('value') }}"
                           required>
                </div>

                {{-- Ngày bắt đầu --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Bắt đầu</label>
                    <input type="datetime-local"
                           name="start_at"
                           class="form-control"
                           value="{{ old('start_at') }}">
                </div>

                {{-- Ngày kết thúc --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kết thúc</label>
                    <input type="datetime-local"
                           name="end_at"
                           class="form-control"
                           value="{{ old('end_at') }}">
                </div>

                {{-- Kích hoạt --}}
                <div class="col-12">
                    <input type="hidden" name="is_active" value="0">

                    <div class="form-check form-switch">
                        <input class="form-check-input"
                               type="checkbox"
                               name="is_active"
                               value="1"
                               checked>
                        <label class="form-check-label fw-semibold">
                            Kích hoạt khuyến mãi
                        </label>
                    </div>
                </div>

            </div>
            {{-- SẢN PHẨM ÁP DỤNG --}}
            <div class="col-12">
                <label class="form-label fw-semibold">
                    Áp dụng cho sản phẩm
                </label>

                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input"
                                    type="checkbox"
                                    name="products[]"
                                    value="{{ $product->id }}"
                                    {{ isset($selectedProducts) && in_array($product->id, $selectedProducts) ? 'checked' : '' }}>
                                <label class="form-check-label">
                                    {{ $product->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card-footer text-end">
                <a href="{{ route('admin.promotions.index') }}"
                   class="btn btn-secondary">
                    Quay lại
                </a>

                <button class="btn btn-danger">
                    Tạo khuyến mãi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
