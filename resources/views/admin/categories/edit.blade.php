@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">✏ Sửa danh mục</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Tên danh mục --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên danh mục</label>
                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $category->name) }}"
                           placeholder="Nhập tên danh mục">

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- SPORT --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Môn thể thao</label>
                    <select name="sport_id" class="form-control">
                        <option value="">-- Chưa gán --</option>
                        @foreach($sports as $sport)
                            <option value="{{ $sport->id }}"
                                {{ old('sport_id', $category->sport_id) == $sport->id ? 'selected' : '' }}>
                                {{ $sport->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- HAS SIZE --}}
                <input type="hidden" name="has_size" value="0">
                <div class="mb-3 form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        name="has_size"
                        value="1"
                        id="has_size"
                        {{ old('has_size', $category->has_size) ? 'checked' : '' }}>
                    <label class="form-check-label" for="has_size">
                        Có size
                    </label>
                </div>

                {{-- HAS COLOR --}}
                <input type="hidden" name="has_color" value="0">
                <div class="mb-4 form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        name="has_color"
                        value="1"
                        id="has_color"
                        {{ old('has_color', $category->has_color) ? 'checked' : '' }}>
                    <label class="form-check-label" for="has_color">
                        Có màu
                    </label>
                </div>

                {{-- Button --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning">
                        💾 Cập nhật
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
