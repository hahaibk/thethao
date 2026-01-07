@extends('admin.layout')

@section('content')
<h2>Thêm người dùng</h2>

<form action="{{ route('admin.users.store') }}" method="POST">
    @csrf

    <div>
        <label>Tên</label><br>
        <input type="text" name="name" value="{{ old('name') }}">
        @error('name') <p style="color:red">{{ $message }}</p> @enderror
    </div>

    <div>
        <label>Email</label><br>
        <input type="email" name="email" value="{{ old('email') }}">
        @error('email') <p style="color:red">{{ $message }}</p> @enderror
    </div>

    <div>
        <label>Mật khẩu</label><br>
        <input type="password" name="password">
        @error('password') <p style="color:red">{{ $message }}</p> @enderror
    </div>

    <div>
        <label>Quyền</label><br>
        <select name="role">
            <option value="0">User</option>
            <option value="1">Admin</option>
        </select>
    </div>

    <br>
    <button type="submit">💾 Lưu</button>
    <a href="{{ route('admin.users.index') }}">⬅ Quay lại</a>
</form>
@endsection
