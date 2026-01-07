@extends('admin.layout')

@section('content')
<h2>Thêm danh mục</h2>

<form action="{{ route('admin.categories.store') }}" method="POST">
    @csrf

    <div>
        <label>Tên danh mục</label><br>
        <input type="text" name="name" value="{{ old('name') }}">
        @error('name')
            <p style="color:red">{{ $message }}</p>
        @enderror
    </div>

    <br>

    <label>
        <input type="checkbox" name="has_size" value="1">
        Có size
    </label>

    <br>

    <label>
        <input type="checkbox" name="has_color" value="1">
        Có màu
    </label>

    <br><br>

    <button type="submit">💾 Lưu</button>
    <a href="{{ route('admin.categories.index') }}">⬅ Quay lại</a>
</form>
@endsection
