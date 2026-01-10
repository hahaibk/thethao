@extends('admin.layout')
@section('content')

<h1>{{ $product->id ? 'Cập nhật sản phẩm' : 'Tạo sản phẩm mới' }}</h1>

<form action="{{ $product->id ? route('admin.products.update',$product) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($product->id) @method('PUT') @endif

    {{-- Tên sản phẩm --}}
    <div class="form-group">
        <label>Tên sản phẩm</label>
        <input type="text" name="name" value="{{ old('name',$product->name) }}" required>
    </div>

    {{-- Giá --}}
    <div class="form-group">
        <label>Giá</label>
        <input type="number" name="price" value="{{ old('price',$product->price) }}" required>
    </div>

    {{-- Danh mục --}}
    <div class="form-group">
        <label>Danh mục</label>
        <select name="category_id" id="category-select" required>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}"
                    data-has-color="{{ $cat->has_color ?? 0 }}"
                    data-has-size="{{ $cat->has_size ?? 0 }}"
                    @if(old('category_id',$product->category_id)==$cat->id) selected @endif>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Mô tả --}}
    <div class="form-group">
        <label>Mô tả</label>
        <textarea name="description">{{ old('description',$product->description) }}</textarea>
    </div>

    {{-- Ảnh chung --}}
    <div class="form-group">
        <label>Ảnh chung</label>
        <input type="file" name="images[]" multiple>

        @if($product->images && count($product->images))
            <div class="image-preview">
                @foreach($product->images as $img)
                    <div class="img-box" data-id="{{ $img->id }}" data-type="product">
                        <img src="{{ asset('storage/'.$img->image_path) }}" width="80">
                        <button type="button" class="delete-image">X</button>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Biến thể --}}
    <h3>Biến thể</h3>
    <div id="variants">
        @php $oldVariants = old('variants',$product->variants->toArray() ?? []); @endphp
        @foreach($oldVariants as $i => $v)
            <div class="variant-card">
                <input type="hidden" name="variants[{{$i}}][id]" value="{{ $v['id'] ?? '' }}">

                <div class="variant-color">
                    <label>Màu</label>
                    <input type="text" name="variants[{{$i}}][color]" value="{{ $v['color'] ?? '' }}">
                </div>

                <div class="variant-size">
                    <label>Size</label>
                    <input type="text" name="variants[{{$i}}][size]" value="{{ $v['size'] ?? '' }}">
                </div>

                <div>
                    <label>Số lượng</label>
                    <input type="number" name="variants[{{$i}}][quantity]" value="{{ $v['quantity'] ?? 0 }}" required>
                </div>

                {{-- Ảnh biến thể --}}
                <div>
                    <label>Ảnh biến thể</label>
                    <input type="file" name="variants[{{$i}}][images][]" multiple>

                    @if(isset($v['images']) && count($v['images']))
                        <div class="image-preview">
                            @foreach($v['images'] as $img)
                                <div class="img-box" data-id="{{ $img['id'] ?? 0 }}" data-type="variant">
                                    <img src="{{ asset('storage/'.$img['image_path']) }}" width="80">
                                    <button type="button" class="delete-image">X</button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <button type="button" onclick="this.closest('.variant-card').remove()">Xóa biến thể</button>
            </div>
        @endforeach
    </div>

    <button type="button" onclick="addVariant()">Thêm biến thể</button>
    <br><br>
    <button type="submit">Lưu</button>
</form>

<script>
let variantIndex = {{ count($oldVariants) }};

// Thêm variant
function addVariant(){
    const container = document.getElementById('variants');
    const div = document.createElement('div');
    div.classList.add('variant-card');

    div.innerHTML = `
        <div class="variant-color">
            <label>Màu</label>
            <input type="text" name="variants[${variantIndex}][color]">
        </div>
        <div class="variant-size">
            <label>Size</label>
            <input type="text" name="variants[${variantIndex}][size]">
        </div>
        <div>
            <label>Số lượng</label>
            <input type="number" name="variants[${variantIndex}][quantity]" value="0" required>
        </div>
        <div>
            <label>Ảnh biến thể</label>
            <input type="file" name="variants[${variantIndex}][images][]" multiple>
        </div>
        <button type="button" onclick="this.closest('.variant-card').remove()">Xóa biến thể</button>
    `;
    container.appendChild(div);
    variantIndex++;
}

// Ẩn/hiện color & size theo category
function updateVariantVisibility(){
    const select = document.getElementById('category-select');
    const hasColor = select.selectedOptions[0].dataset.hasColor == 1;
    const hasSize = select.selectedOptions[0].dataset.hasSize == 1;

    document.querySelectorAll('.variant-card').forEach(card=>{
        card.querySelector('.variant-color').style.display = hasColor?'block':'none';
        card.querySelector('.variant-size').style.display = hasSize?'block':'none';
    });
}

updateVariantVisibility();
document.getElementById('category-select').addEventListener('change', updateVariantVisibility);

// AJAX xóa ảnh
document.querySelectorAll('.delete-image').forEach(btn=>{
    btn.addEventListener('click', function(){
        if(!confirm('Xóa ảnh này?')) return;

        const box = this.closest('.img-box');
        const id = box.dataset.id;
        const type = box.dataset.type;
        let url = '';

        if(type==='product') url = `/admin/product-images/${id}`;
        else url = `/admin/variant-images/${id}`;

        fetch(url,{
            method:'DELETE',
            headers:{
                'X-CSRF-TOKEN':'{{ csrf_token() }}',
                'Accept':'application/json'
            }
        })
        .then(res=>res.json())
        .then(data=>{
            if(data.success) box.remove();
            else alert('Xóa thất bại!');
        })
        .catch(err=>{console.error(err); alert('Xóa thất bại!');});
    });
});
</script>

<style>
.form-group {margin-bottom:15px;}
.form-group label {display:block;margin-bottom:5px;font-weight:bold;}
.form-group input, .form-group select, .form-group textarea {width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;}
.variant-card {border:1px solid #ddd;padding:10px;margin-bottom:10px;border-radius:6px;background:#fafafa;}
.image-preview {display:flex;gap:5px;margin-top:5px;flex-wrap:wrap;}
.img-box {position:relative;}
.img-box img {border:1px solid #ccc;border-radius:4px;}
.img-box button {position:absolute; top:0; right:0;}
</style>

@endsection
