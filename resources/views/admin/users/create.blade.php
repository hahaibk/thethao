@extends('admin.layout')

@section('content')
<div class="container mt-4" style="max-width:700px">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">✏ Sửa người dùng</h3>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            ⬅ Quay lại
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- TÊN --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tên</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', $user->name) }}"
                           required>
                </div>

                {{-- EMAIL --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="{{ $user->email }}"
                           readonly>
                    <small class="text-muted">
                        Email không thể thay đổi
                    </small>
                </div>

                {{-- QUYỀN --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Vai trò</label>
                    <select name="role" class="form-select" required>
                        <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>
                            User
                        </option>
                        <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>
                            Admin
                        </option>
                    </select>
                </div>

                {{-- KHÓA ĐĂNG NHẬP --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Trạng thái tài khoản</label>
                    <select name="is_locked" class="form-select" required>
                        <option value="0" {{ $user->is_locked == 0 ? 'selected' : '' }}>
                            Hoạt động
                        </option>
                        <option value="1" {{ $user->is_locked == 1 ? 'selected' : '' }}>
                            Khóa đăng nhập
                        </option>
                    </select>
                </div>

                {{-- ACTION --}}
                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        💾 Lưu
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                        Hủy
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
