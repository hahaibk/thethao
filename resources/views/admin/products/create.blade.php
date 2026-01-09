@extends('admin.layout')

@section('content')
<h1>{{ $product->id ? 'Cập nhật sản phẩm' : 'Tạo sản phẩm mới' }}</h1>

<form action="{{ $product->id ? route('admin.products.update',$product) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($product->id) @method('PUT') @endif

    <div class="form-group">
        <label>Tên sản phẩm</label>
        <input type="text" name="name" value="{{ old('name',$product->name) }}" required>
    </div>

    <div class="form-group">
        <label>Giá</label>
        <input type="number" name="price" value="{{ old('price',$product->price) }}" required>
    </div>

    <div class="form-group">
        <label>Danh mục</label>
        <select name="category_id" required>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" @if(old('category_id',$product->category_id)==$cat->id) selected @endif>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Mô tả</label>
        <textarea name="description">{{ old('description',$product->description) }}</textarea>
    </div>

    <div class="form-group">
        <label>Ảnh sản phẩm chung</label>
        <input type="file" name="images[]" multiple>
        @if($product->images)
            <div class="image-preview">
                @foreach($product->images as $img)
                    <div class="img-box">
                        <img src="{{ $img->image_path }}" alt="" width="80">
                        <form action="{{ route('admin.product_images.destroy',$img) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Xóa ảnh này?')">Xóa</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <h3>Biến thể</h3>
    <div id="variants">
        @php $oldVariants = old('variants',$product->variants->toArray() ?? []); @endphp
        @foreach($oldVariants as $i => $v)
        <div class="variant-card">
            <input type="hidden" name="variants[{{ $i }}][id]" value="{{ $v['id'] ?? '' }}">
            <div>
                <label>Màu</label>
                <input type="text" name="variants[{{ $i }}][color]" value="{{ $v['color'] }}" required>
            </div>
            <div>
                <label>Size</label>
                <input type="text" name="variants[{{ $i }}][size]" value="{{ $v['size'] }}" required>
            </div>
            <div>
                <label>Số lượng</label>
                <input type="number" name="variants[{{ $i }}][quantity]" value="{{ $v['quantity'] }}" required>
            </div>
            

            <div>
                <label>Ảnh biến thể</label>
                <input type="file" name="variants[{{ $i }}][images][]" multiple>
                @if(isset($v['images']))
                    <div class="image-preview">
                        @foreach($v['images'] as $img)
                        <div class="img-box">
                            <img src="{{ $img['image_path'] }}" alt="" width="80">
                            <form action="{{ route('admin.product_images.destroy', $img['id']) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Xóa ảnh này?')">Xóa</button>
                            </form>
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
function addVariant(){
    const container = document.getElementById('variants');
    const div = document.createElement('div');
    div.classList.add('variant-card');
    div.innerHTML = `
        <div>
            <label>Màu</label>
            <input type="text" name="variants[${variantIndex}][color]" required>
        </div>
        <div>
            <label>Size</label>
            <input type="text" name="variants[${variantIndex}][size]" required>
        </div>
        <div>
            <label>Số lượng</label>
            <input type="number" name="variants[${variantIndex}][quantity]" required>
        </div>
        <div>
            <label>Giá</label>
            <input type="number" step="0.01" name="variants[${variantIndex}][price]">
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
</script>

<style>
.form-group { margin-bottom:15px; }
.form-group label { display:block; margin-bottom:5px; font-weight:bold; }
.form-group input, .form-group select, .form-group textarea { width:100%; padding:8px; border:1px solid #ccc; border-radius:4px; }

.variant-card { border:1px solid #ddd; padding:10px; margin-bottom:10px; border-radius:6px; background:#fafafa; }
.image-preview { display:flex; gap:5px; margin-top:5px; flex-wrap:wrap; }
.img-box { position:relative; }
.img-box form { position:absolute; top:0; right:0; }
.img-box img { display:block; border:1px solid #ccc; border-radius:4px; }
</style>
@endsection
