@extends('admin.layout')

@section('content')
<h2>Sửa danh mục</h2>

<form action="{{ route('admin.categories.update', $category) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>Tên danh mục</label><br>
        <input type="text" name="name" value="{{ old('name', $category->name) }}">
        @error('name')
            <p style="color:red">{{ $message }}</p>
        @enderror
    </div>

    <br>

    <label>
        <input type="checkbox" name="has_size" value="1"
               {{ $category->has_size ? 'checked' : '' }}>
        Có size
    </label>

    <br>

    <label>
        <input type="checkbox" name="has_color" value="1"
               {{ $category->has_color ? 'checked' : '' }}>
        Có màu
    </label>

    <br><br>

    <button type="submit">💾 Cập nhật</button>
    <a href="{{ route('admin.categories.index') }}">⬅ Quay lại</a>
</form>
@endsection
