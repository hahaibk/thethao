@extends('admin.layout')

@section('title', 'Quản lý Banner')

@section('content')
<div class="container">
    <h1>Danh sách Banner</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.homesection.banner.create') }}" class="btn btn-primary mb-3">Thêm Banner</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Ảnh</th>
                <th>Tiêu đề</th>
                <th>Sort Order</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($banners as $banner)
            <tr>
                <td>{{ $banner->id }}</td>
                <td>
                    @if($banner->image)
                        <img src="{{ asset('storage/' . $banner->image) }}"
                            alt="Banner"
                            width="120"
                            class="img-thumbnail">
                    @else
                        <span class="text-muted">No image</span>
                    @endif
                </td>
                                <td>{{ $banner->title }}</td>
                <td>{{ $banner->sort_order }}</td>
                <td>
                    <a href="{{ route('admin.homesection.banner.edit', $banner->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                    <form action="{{ route('admin.homesection.banner.destroy', $banner->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Chưa có banner nào</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
