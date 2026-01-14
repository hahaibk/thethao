@extends('admin.layout')

@section('content')
<div class="container mt-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">👥 Quản lý người dùng</h2>

        <a href="{{ route('admin.users.create') }}" class="btn btn-warning fw-semibold">
            ➕ Thêm user
        </a>
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success py-2">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="table-responsive bg-white rounded shadow-sm">
        <table class="table table-bordered align-middle mb-0">
            <thead class="table-light text-center">
                <tr>
                    <th width="60">ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th width="120">Quyền</th>
                    <th width="140">Trạng thái</th>
                    <th width="160">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="text-center">{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>

                    {{-- QUYỀN --}}
                    <td class="text-center">
                        @if($user->role == 1)
                            <span class="badge bg-warning text-dark">Admin</span>
                        @else
                            <span class="badge bg-secondary">User</span>
                        @endif
                    </td>

                    {{-- KHÓA ĐĂNG NHẬP --}}
                    <td class="text-center">
                        @if($user->is_locked)
                            <span class="badge bg-danger">Khóa</span>
                        @else
                            <span class="badge bg-success">Hoạt động</span>
                        @endif
                    </td>

                    {{-- ACTION --}}
                    <td class="text-center">
                        <a href="{{ route('admin.users.show', $user) }}"
                           class="btn btn-sm btn-primary">👁</a>

                        <a href="{{ route('admin.users.edit', $user) }}"
                           class="btn btn-sm btn-warning">✏</a>

                        <form action="{{ route('admin.users.destroy', $user) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Xóa user này?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">🗑</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        Không có user nào
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $users->links() }}
    </div>

</div>
@endsection
