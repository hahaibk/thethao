@extends('admin.layout')

@section('content')
<h2>Quản lý danh mục</h2>

<a href="{{ route('admin.categories.create') }}">➕ Thêm danh mục</a>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Có size</th>
            <th>Có màu</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->has_size ? '✔' : '✖' }}</td>
            <td>{{ $category->has_color ? '✔' : '✖' }}</td>
            <td>
                <a href="{{ route('admin.categories.edit', $category) }}">✏ Sửa</a>

                <form action="{{ route('admin.categories.destroy', $category) }}"
                      method="POST"
                      style="display:inline"
                      onsubmit="return confirm('Xóa danh mục này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">🗑 Xóa</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<br>
{{ $categories->links() }}
@endsection
