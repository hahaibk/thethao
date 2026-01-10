@extends('admin.layout')

@section('title', 'Thêm Banner')

@section('content')
<div class="container">
    <h1>Thêm Banner</h1>

    <a href="{{ route('admin.homesection.banner.index') }}" class="btn btn-secondary mb-3">Quay lại</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.homesection.banner.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Ảnh</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
            <div class="mt-2">
                <img id="preview" src="#" alt="Preview" style="display:none; max-height:200px; object-fit:cover;">
            </div>
        </div>

        <div class="mb-3">
            <label for="sort_order" class="form-label">Sort Order</label>
            <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
        </div>

        <button type="submit" class="btn btn-success">Lưu</button>
    </form>
</div>

{{-- JS preview ảnh --}}
@section('scripts')
<script>
document.getElementById('image').addEventListener('change', function(event){
    const [file] = event.target.files;
    const preview = document.getElementById('preview');
    if(file){
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
});
</script>
@endsection

@endsection
