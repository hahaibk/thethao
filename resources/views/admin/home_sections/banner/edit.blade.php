<form action="{{ route('admin.homesection.banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Tiêu đề</label>
        <input type="text" name="title" value="{{ old('title', $banner->title) }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Subtitle</label>
        <input type="text" name="subtitle" value="{{ old('subtitle', $banner->subtitle) }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Link</label>
        <input type="text" name="link" value="{{ old('link', $banner->link) }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Ảnh</label>

        {{-- Ảnh cũ --}}
        @if($banner->image && file_exists(public_path('storage/'.$banner->image)))
            <div class="mb-2">
                <img src="{{ asset('storage/'.$banner->image) }}" style="max-height:150px; object-fit:cover;">
            </div>
        @endif

        <input type="file" name="image" id="image" class="form-control" accept="image/*">

        {{-- Preview ảnh mới --}}
        <div class="mt-2">
            <img id="preview" src="#" style="display:none; max-height:150px; object-fit:cover;">
        </div>
    </div>

    <div class="mb-3">
        <label>Sort order</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $banner->sort_order) }}" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Cập nhật</button>
</form>

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
