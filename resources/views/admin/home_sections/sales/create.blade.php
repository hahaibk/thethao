@extends('admin.layout')

@section('title', isset($sale) ? 'Sửa Sale' : 'Thêm Sale')
@section('page-title', isset($sale) ? 'Sửa Sale' : 'Thêm Sale')

@section('content')
<div class="container-fluid">

    <div class="card shadow-sm">
        <div class="card-header fw-bold">
            <i class="bi bi-tags"></i>
            {{ isset($sale) ? 'Cập nhật Sale' : 'Tạo Sale mới' }}
        </div>

        <div class="card-body">
            <form method="POST"
                  action="{{ isset($sale)
                            ? route('admin.homesection.sales.update', $sale->id)
                            : route('admin.homesection.sales.store') }}"
                  enctype="multipart/form-data">

                @csrf
                @isset($sale)
                    @method('PUT')
                @endisset

                {{-- TITLE --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Tiêu đề Sale <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="title"
                           class="form-control"
                           value="{{ old('title', $sale->title ?? '') }}"
                           required>
                </div>

                {{-- SUBTITLE --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Mô tả ngắn
                    </label>
                    <input type="text"
                           name="subtitle"
                           class="form-control"
                           value="{{ old('subtitle', $sale->subtitle ?? '') }}">
                </div>

                {{-- THUMBNAIL --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Ảnh đại diện
                    </label>
                    <input type="file"
                           name="thumbnail"
                           class="form-control">

                    @if(isset($sale) && $sale->thumbnail)
                        <div class="mt-2">
                            <img src="{{ asset('storage/'.$sale->thumbnail) }}"
                                 class="img-thumbnail"
                                 width="220">
                        </div>
                    @endif
                </div>

                {{-- CONTENT --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Nội dung Sale
                    </label>
                    <textarea name="content"
                              id="content"
                              rows="10"
                              class="form-control">{{ old('content', $sale->content ?? '') }}</textarea>
                    <small class="text-muted">
                        Có thể chèn ảnh, bảng, định dạng như Word
                    </small>
                </div>

                {{-- ACTION --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.homesection.sales.index') }}"
                       class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>

                    <button class="btn btn-primary">
                        <i class="bi bi-save"></i> Lưu
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>
    CKEDITOR.replace('content', {
        height: 350
    });
</script>
@endsection
