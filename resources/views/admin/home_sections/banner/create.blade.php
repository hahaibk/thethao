@extends('admin.layout')

@section('title', $banner->exists ? 'Sửa Banner' : 'Thêm Banner')

@section('styles')
<style>
    .banner-form .card {
        border-radius: 12px;
    }

    .banner-form .form-label {
        font-weight: 600;
    }

    .banner-form .image-preview {
        max-height: 180px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .banner-form .btn {
        min-width: 120px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid banner-form">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            {{ $banner->exists ? '✏️ Sửa Banner' : '➕ Thêm Banner' }}
        </h4>
        <a href="{{ route('admin.homesection.banner.index') }}"
           class="btn btn-outline-secondary btn-sm">
            ← Quay lại
        </a>
    </div>

    {{-- Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <form
                action="{{ $banner->exists
                    ? route('admin.homesection.banner.save', $banner->id)
                    : route('admin.homesection.banner.store') }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf
                @if($banner->exists)
                    @method('PUT')
                @endif

                <div class="row g-3">

                    {{-- Title --}}
                    <div class="col-md-6">
                        <label class="form-label">Tiêu đề</label>
                        <input type="text"
                               name="title"
                               class="form-control"
                               value="{{ old('title', $banner->title) }}"
                               required>
                    </div>

                    {{-- Sort order --}}
                    <div class="col-md-3">
                        <label class="form-label">Sort order</label>
                        <input type="number"
                               name="sort_order"
                               class="form-control"
                               value="{{ old('sort_order', $banner->sort_order ?? 0) }}">
                    </div>

                    {{-- Active --}}
                    <div class="col-md-3">
                        <label class="form-label">Trạng thái</label>
                        <select name="is_active" class="form-select">
                            <option value="1" {{ old('is_active', $banner->is_active) == 1 ? 'selected' : '' }}>
                                Hiển thị
                            </option>
                            <option value="0" {{ old('is_active', $banner->is_active) == 0 ? 'selected' : '' }}>
                                Ẩn
                            </option>
                        </select>
                    </div>

                    {{-- Subtitle --}}
                    <div class="col-md-12">
                        <label class="form-label">Tiêu đề phụ</label>
                        <input type="text"
                               name="subtitle"
                               class="form-control"
                               value="{{ old('subtitle', $banner->subtitle) }}">
                    </div>

                    {{-- Link --}}
                    <div class="col-md-12">
                        <label class="form-label">Link</label>
                        <input type="text"
                               name="link"
                               class="form-control"
                               placeholder="https://..."
                               value="{{ old('link', $banner->link) }}">
                    </div>

                    {{-- Image --}}
                    <div class="col-md-12">
                        <label class="form-label">Ảnh banner</label>
                        <input type="file"
                               name="image"
                               class="form-control"
                               accept="image/*"
                               onchange="previewImage(this)">
                    </div>

                    {{-- Preview --}}
                    <div class="col-md-12">
                        @if($banner->image)
                            <img id="imagePreview"
                                 src="{{ asset('storage/'.$banner->image) }}"
                                 class="image-preview mt-2">
                        @else
                            <img id="imagePreview"
                                 class="image-preview mt-2"
                                 style="display:none">
                        @endif
                    </div>

                </div>

                {{-- Actions --}}
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        💾 Lưu
                    </button>

                    @if($banner->exists)
                        <form action="{{ route('admin.homesection.banner.destroy', $banner->id) }}"
                              method="POST"
                              onsubmit="return confirm('Bạn có chắc muốn xóa banner này?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">
                                🗑 Xóa
                            </button>
                        </form>
                    @endif
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const file = input.files[0];

    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
}
</script>
@endsection
