@extends('admin.layout')

@section('content')
<h2>Sửa người dùng</h2>

<form action="{{ route('admin.users.update', $user) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>Tên</label><br>
        <input type="text" name="name"
               value="{{ old('name', $user->name) }}">
    </div>

    <div>
        <label>Email</label><br>
        <input type="email" name="email"
               value="{{ old('email', $user->email) }}">
    </div>

    <div>
        <label>Mật khẩu (bỏ trống nếu không đổi)</label><br>
        <input type="password" name="password">
    </div>

    <div>
        <label>Quyền</label><br>
        <select name="role">
            <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>User</option>
            <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Admin</option>
        </select>
    </div>

    <br>
    <button type="submit">💾 Cập nhật</button>
    <a href="{{ route('admin.users.index') }}">⬅ Quay lại</a>
</form>
@endsection
