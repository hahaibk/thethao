@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">📂 Quản lý danh mục</h5>

            <a href="{{ route('admin.categories.create') }}"
               class="btn btn-success btn-sm">
                ➕ Thêm danh mục
            </a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Có size</th>
                            <th>Có màu</th>
                            <th width="180">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td class="text-center">{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td class="text-center">
                                    @if($category->has_size)
                                        <span class="badge bg-success">✔</span>
                                    @else
                                        <span class="badge bg-secondary">✖</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($category->has_color)
                                        <span class="badge bg-success">✔</span>
                                    @else
                                        <span class="badge bg-secondary">✖</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                       class="btn btn-warning btn-sm">
                                        ✏ Sửa
                                    </a>

                                    <form action="{{ route('admin.categories.destroy', $category) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Xóa danh mục này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-danger btn-sm">
                                            🗑 Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Chưa có danh mục nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
