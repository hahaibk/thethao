@extends('admin.layout')

@section('title', isset($event) ? 'Sửa Event' : 'Thêm Event')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">
            {{ isset($event) ? 'Sửa Event' : 'Thêm Event' }}
        </h5>
    </div>

    <div class="card-body">
        <form method="POST"
              enctype="multipart/form-data"
              action="{{ isset($event)
                    ? route('admin.homesection.events.update', $event)
                    : route('admin.homesection.events.store') }}">

            @csrf
            @isset($event) @method('PUT') @endisset

            <div class="mb-3">
                <label class="form-label">Tiêu đề</label>
                <input type="text"
                       name="title"
                       class="form-control"
                       value="{{ old('title', $event->title ?? '') }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tiêu đề phụ</label>
                <input type="text"
                       name="subtitle"
                       class="form-control"
                       value="{{ old('subtitle', $event->subtitle ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Ảnh đại diện</label>
                <input type="file" name="thumbnail" class="form-control">

                @if(isset($event) && $event->thumbnail)
                    <img src="{{ asset('storage/'.$event->thumbnail) }}"
                         class="img-thumbnail mt-2"
                         width="150">
                @endif
            </div>

            <div class="mb-3">
                <label class="form-label">Nội dung</label>
                <textarea name="content"
                          id="content"
                          class="form-control"
                          rows="6">{{ old('content', $event->content ?? '') }}</textarea>
            </div>

            <button class="btn btn-success">
                💾 Lưu
            </button>

            <a href="{{ route('admin.homesection.events.index') }}"
               class="btn btn-secondary">
                ⬅ Quay lại
            </a>
        </form>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('content');
</script>
@endsection
