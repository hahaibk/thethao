@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header fw-bold">
            ➕ Thêm môn thể thao
        </div>

        <div class="card-body">
            <form method="POST"
                  action="{{ route('admin.sports.store') }}"
                  enctype="multipart/form-data">
                @csrf

                {{-- Tên --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên môn thể thao</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           placeholder="VD: Cầu lông, Bóng đá..."
                           required>
                </div>

                {{-- Sort order --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Thứ tự hiển thị
                        <small class="text-muted">(số nhỏ hiển thị trước)</small>
                    </label>
                    <input type="number"
                           name="sort_order"
                           class="form-control"
                           value="0">
                </div>

                {{-- Ảnh --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">Ảnh đại diện</label>
                    <input type="file" name="image" class="form-control">
                </div>

                {{-- Button --}}
                <div class="d-flex gap-2">
                    <button class="btn btn-primary">
                        💾 Lưu
                    </button>
                    <a href="{{ route('admin.sports.index') }}"
                       class="btn btn-secondary">
                        ⬅ Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
