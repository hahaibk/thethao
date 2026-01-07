@extends('admin.layout')

@section('content')
<h2>Quản lý người dùng</h2>

<a href="{{ route('admin.users.create') }}" style="display:inline-block; margin-bottom:15px; padding:8px 12px; background:#16a34a; color:#fff; border-radius:5px; text-decoration:none;">
    ➕ Thêm user
</a>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="8" cellspacing="0" width="100%" style="border-collapse: collapse;">
    <thead style="background:#f3f3f3;">
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
                @if($user->role === 'admin')
                    <span style="color:#d97706; font-weight:bold;">Admin</span>
                @else
                    <span style="color:#047857;">User</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.users.show', $user) }}" style="margin-right:5px;">👁</a>
                <a href="{{ route('admin.users.edit', $user) }}" style="margin-right:5px;">✏</a>

                <form action="{{ route('admin.users.destroy', $user) }}"
                      method="POST"
                      style="display:inline"
                      onsubmit="return confirm('Xóa user này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background:none; border:none; color:red; cursor:pointer;">🗑</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<br>
{{-- Phân trang --}}
<div style="margin-top:15px;">
    {{ $users->links() }}
</div>
@endsection
