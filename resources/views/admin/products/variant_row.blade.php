<div class="card p-3 mb-3 border">
    <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $v->id ?? '' }}">

    <div class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label">Màu</label>
            <input type="text"
                   class="form-control"
                   name="variants[{{ $index }}][color]"
                   value="{{ $v->color ?? '' }}"
                   required>
        </div>

        <div class="col-md-2">
            <label class="form-label">Size</label>
            <input type="text"
                   class="form-control"
                   name="variants[{{ $index }}][size]"
                   value="{{ $v->size ?? '' }}"
                   required>
        </div>

        <div class="col-md-2">
            <label class="form-label">Số lượng</label>
            <input type="number"
                   class="form-control"
                   name="variants[{{ $index }}][quantity]"
                   value="{{ $v->quantity ?? 0 }}"
                   min="0"
                   required>
        </div>

        <div class="col-md-2">
            <label class="form-label">Giá</label>
            <input type="number"
                   class="form-control"
                   name="variants[{{ $index }}][price]"
                   value="{{ $v->price ?? '' }}">
        </div>

        <div class="col-md-3">
            <label class="form-label">Ảnh variant</label>
            <input type="file"
                   class="form-control"
                   name="variants[{{ $index }}][images][]"
                   multiple {{ empty($v) ? 'required' : '' }}>
        </div>
    </div>

    @if(!empty($v?->images))
        <div class="mt-2 d-flex gap-2 flex-wrap">
            @foreach($v->images as $img)
                <img src="{{ asset('storage/' . $img->image_path) }}"
                     style="width:50px;height:50px;object-fit:cover;border-radius:6px;">
            @endforeach
        </div>
    @endif
</div>
