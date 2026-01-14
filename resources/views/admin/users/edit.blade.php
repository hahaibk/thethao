@extends('admin.layout')

@section('content')

<h1>Sửa người dùng</h1>

<form action="{{ route('admin.users.update', $user) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- Tên --}}
    <div class="form-group">
        <label>Tên</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
    </div>

    {{-- Email (readonly, vẫn gửi khi submit) --}}
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="{{ $user->email }}" readonly>
    </div>

    {{-- Vai trò --}}
    <div class="form-group">
        <label>Vai trò</label>
        <select name="role" required>
            <option value="user" {{ $user->role=='user' ? 'selected' : '' }}>User</option>
            <option value="admin" {{ $user->role=='admin' ? 'selected' : '' }}>Admin</option>
        </select>
    </div>

    {{-- Khóa đăng nhập --}}
    <div class="form-group">
        <label>Trạng thái tài khoản</label>
        <select name="is_locked" required>
            <option value="0" {{ $user->is_locked==0 ? 'selected' : '' }}>Hoạt động</option>
            <option value="1" {{ $user->is_locked==1 ? 'selected' : '' }}>Khóa</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Lưu</button>
</form>

@endsection
