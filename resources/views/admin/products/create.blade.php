@extends('admin.layout')

@section('content')

<h1>{{ $product->id ? 'Cập nhật sản phẩm' : 'Tạo sản phẩm mới' }}</h1>

<form action="{{ $product->id ? route('admin.products.update',$product) : route('admin.products.store') }}"
      method="POST" enctype="multipart/form-data">
    @csrf
    @if($product->id) @method('PUT') @endif

    {{-- TÊN --}}
    <div class="form-group">
        <label>Tên sản phẩm</label>
        <input type="text" name="name" value="{{ old('name',$product->name) }}" required>
    </div>

    {{-- GIÁ --}}
    <div class="form-group">
        <label>Giá</label>
        <input type="number" name="price" value="{{ old('price',$product->price) }}" required>
    </div>

    {{-- SPORT --}}
    <div class="form-group">
        <label>Môn thể thao</label>
        <select id="sport-select">
            <option value="">— Chọn môn thể thao —</option>
            @foreach($sports as $sport)
                <option value="{{ $sport->id }}"
                    {{ old('sport_id',$product->category->sport_id ?? '') == $sport->id ? 'selected' : '' }}>
                    {{ $sport->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- CATEGORY --}}
    <div class="form-group">
        <label>Danh mục</label>
        <select name="category_id" id="category-select" required>
            <option value="">— Chọn danh mục —</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}"
                    data-has-color="{{ $cat->has_color ? 1 : 0 }}"
                    data-has-size="{{ $cat->has_size ? 1 : 0 }}"
                    {{ old('category_id',$product->category_id)==$cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- MÔ TẢ --}}
    <div class="form-group">
        <label>Mô tả</label>
        <textarea name="description">{{ old('description',$product->description) }}</textarea>
    </div>

    {{-- BIẾN THỂ --}}
    <h3>Biến thể</h3>
    <div id="variants">
        @php $oldVariants = old('variants', $product->variants->toArray() ?? []); @endphp

        @foreach($oldVariants as $i => $v)
            <div class="variant-card">
                <div class="variant-color">
                    <label>Màu</label>
                    <input type="text" name="variants[{{ $i }}][color]" value="{{ $v['color'] ?? '' }}">
                </div>

                <div class="variant-size">
                    <label>Size</label>
                    <input type="text" name="variants[{{ $i }}][size]" value="{{ $v['size'] ?? '' }}">
                </div>

                <div>
                    <label>Số lượng</label>
                    <input type="number" name="variants[{{ $i }}][quantity]" value="{{ $v['quantity'] ?? 0 }}" required>
                </div>

                <button type="button" onclick="this.closest('.variant-card').remove()">Xóa</button>
            </div>
        @endforeach
    </div>

    <button type="button" onclick="addVariant()">Thêm biến thể</button>
    <br><br>
    <button type="submit">Lưu</button>
</form>

{{-- ================= SCRIPT ================= --}}
<script>
let variantIndex = {{ count($oldVariants) }};

function updateVariantVisibility(){
    const select = document.getElementById('category-select');
    if (!select || !select.value) return;

    const option = select.options[select.selectedIndex];
    if (!option) return;

    const hasColor = option.dataset.hasColor === "1";
    const hasSize  = option.dataset.hasSize === "1";

    document.querySelectorAll('.variant-card').forEach(card=>{
        const colorBox = card.querySelector('.variant-color');
        const sizeBox  = card.querySelector('.variant-size');

        if (colorBox) colorBox.style.display = hasColor ? 'block' : 'none';
        if (sizeBox)  sizeBox.style.display  = hasSize  ? 'block' : 'none';
    });
}

function addVariant(){
    const container = document.getElementById('variants');
    const div = document.createElement('div');
    div.className = 'variant-card';

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

        <button type="button" onclick="this.closest('.variant-card').remove()">Xóa</button>
    `;

    container.appendChild(div);
    variantIndex++;
    updateVariantVisibility();
}

// category change
document.getElementById('category-select')
    ?.addEventListener('change', updateVariantVisibility);

// sport → load category
document.getElementById('sport-select')
    ?.addEventListener('change', function(){
        const sportId = this.value;
        const catSelect = document.getElementById('category-select');

        catSelect.innerHTML = '<option value="">— Chọn danh mục —</option>';

        if(!sportId) return;

        fetch(`/admin/sports/${sportId}/categories`)
            .then(res => res.json())
            .then(data => {
                data.forEach(cat=>{
                    const opt = document.createElement('option');
                    opt.value = cat.id;
                    opt.textContent = cat.name;
                    opt.dataset.hasColor = cat.has_color ? "1" : "0";
                    opt.dataset.hasSize  = cat.has_size ? "1" : "0";
                    catSelect.appendChild(opt);
                });
            });
    });

updateVariantVisibility();
</script>

{{-- ================= STYLE ================= --}}
<style>
.form-group{margin-bottom:15px}
.form-group label{display:block;font-weight:bold;margin-bottom:5px}
.form-group input,select,textarea{
    width:100%;padding:8px;border:1px solid #ccc;border-radius:4px
}
.variant-card{
    border:1px solid #ddd;
    padding:10px;
    margin-bottom:10px;
    border-radius:6px;
    background:#fafafa
}
</style>

@endsection
