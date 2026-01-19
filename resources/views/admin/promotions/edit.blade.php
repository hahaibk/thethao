@extends('admin.layout')

@section('page-title', 'Sửa khuyến mãi')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">

        <div class="card-header bg-warning text-dark fw-bold">
            <i class="bi bi-pencil-square"></i> Sửa khuyến mãi
        </div>

        <form method="POST"
              action="{{ route('admin.promotions.update', $promotion->id) }}">
            @csrf
            @method('PUT')

            <div class="card-body row g-3">

                {{-- TÊN --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tên khuyến mãi</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', $promotion->name) }}"
                           required>
                </div>

                {{-- LOẠI --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Loại giảm</label>
                    <select name="type" class="form-select" required>
                        <option value="percent"
                            {{ old('type', $promotion->type) === 'percent' ? 'selected' : '' }}>
                            Phần trăm (%)
                        </option>
                        <option value="fixed"
                            {{ old('type', $promotion->type) === 'fixed' ? 'selected' : '' }}>
                            Giá cố định (đ)
                        </option>
                    </select>
                </div>

                {{-- GIÁ TRỊ --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Giá trị</label>
                    <input type="number"
                           name="value"
                           class="form-control"
                           value="{{ old('value', $promotion->value) }}"
                           required>
                </div>

                {{-- NGÀY BẮT ĐẦU --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Bắt đầu</label>
                    <input type="datetime-local"
                           name="start_at"
                           class="form-control"
                           value="{{ old('start_at', $promotion->start_at?->format('Y-m-d\TH:i')) }}">
                </div>

                {{-- NGÀY KẾT THÚC --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kết thúc</label>
                    <input type="datetime-local"
                           name="end_at"
                           class="form-control"
                           value="{{ old('end_at', $promotion->end_at?->format('Y-m-d\TH:i')) }}">
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
                {{-- TRẠNG THÁI --}}
                <div class="col-12">
                    {{-- quan trọng: tránh bị ngược --}}
                    <input type="hidden" name="is_active" value="0">

                    <div class="form-check form-switch">
                        <input class="form-check-input"
                               type="checkbox"
                               name="is_active"
                               value="1"
                               {{ old('is_active', $promotion->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold">
                            Kích hoạt khuyến mãi
                        </label>
                    </div>
                </div>

            </div>

            <div class="card-footer text-end bg-light">
                <a href="{{ route('admin.promotions.index') }}"
                   class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>

                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-save"></i> Cập nhật
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
