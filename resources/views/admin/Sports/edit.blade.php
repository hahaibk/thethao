@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header fw-bold">
            ✏ Sửa môn thể thao
        </div>

        <div class="card-body">
            <form method="POST"
                  action="{{ route('admin.sports.update',$sport) }}"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Tên --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên môn thể thao</label>
                    <input type="text"
                           name="name"
                           value="{{ $sport->name }}"
                           class="form-control"
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
                           value="{{ $sport->sort_order }}">
                </div>

                {{-- Ảnh --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">Ảnh đại diện</label>
                    <input type="file" name="image" class="form-control">

                    @if($sport->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/'.$sport->image) }}"
                                 style="width:120px;height:120px;object-fit:cover"
                                 class="rounded border">
                        </div>
                    @endif
                </div>

                {{-- Button --}}
                <div class="d-flex gap-2">
                    <button class="btn btn-warning">
                        💾 Cập nhật
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
