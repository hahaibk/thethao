@extends('admin.layout')

@section('content')
<h2>Thêm sản phẩm</h2>

<form method="POST" action="{{ route('admin.products.store') }}">
    @csrf

    {{-- Tên --}}
    <div>
        <label>Tên sản phẩm</label>
        <input type="text" name="name" required>
    </div>

    {{-- Giá --}}
    <div>
        <label>Giá</label>
        <input type="number" name="price" required>
    </div>

    {{-- Loại --}}
    <div>
        <label>Loại sản phẩm</label>
        <select name="category_id" id="category" required>
            <option value="">-- Chọn loại --</option>
            @foreach($categories as $category)
                <option
                    value="{{ $category->id }}"
                    data-has-color="{{ $category->has_color }}"
                    data-has-size="{{ $category->has_size }}"
                >
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <br>
    <button type="submit">Tạo sản phẩm</button>
</form>
@endsection
