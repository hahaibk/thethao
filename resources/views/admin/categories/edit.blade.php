@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">➕ Thêm danh mục</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                {{-- Tên danh mục --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên danh mục</label>
                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}"
                           placeholder="Nhập tên danh mục">

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Checkbox --}}
                <div class="mb-3 form-check">
                    <input type="checkbox"
                           class="form-check-input"
                           name="has_size"
                           value="1"
                           id="has_size"
                           {{ old('has_size') ? 'checked' : '' }}>
                    <label class="form-check-label" for="has_size">
                        Có size
                    </label>
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox"
                           class="form-check-input"
                           name="has_color"
                           value="1"
                           id="has_color"
                           {{ old('has_color') ? 'checked' : '' }}>
                    <label class="form-check-label" for="has_color">
                        Có màu
                    </label>
                </div>

                {{-- Button --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        💾 Lưu
                    </button>

                    <a href="{{ route('admin.categories.index') }}"
                       class="btn btn-secondary">
                        ⬅ Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
