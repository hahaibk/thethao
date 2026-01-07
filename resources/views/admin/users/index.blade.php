@extends('admin.layout')

@section('content')
<h2>Quản lý người dùng</h2>

<a href="{{ route('admin.users.create') }}">➕ Thêm user</a>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Email</th>
            <th>Quyền</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                {{ $user->role == 1 ? 'Admin' : 'User' }}
            </td>
            <td>
                <a href="{{ route('admin.users.show', $user) }}">👁</a>
                <a href="{{ route('admin.users.edit', $user) }}">✏</a>

                <form action="{{ route('admin.users.destroy', $user) }}"
                      method="POST"
                      style="display:inline"
                      onsubmit="return confirm('Xóa user này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">🗑</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<br>
{{ $users->links() }}
@endsection
