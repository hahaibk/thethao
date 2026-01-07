<h2>Sửa sản phẩm</h2>

<form method="POST" action="{{ route('admin.products.update', $product) }}">
    @csrf
    @method('PUT')

    <input name="name" value="{{ $product->name }}"><br><br>
    <input name="price" value="{{ $product->price }}"><br><br>

    <select name="category_id" required>
        @foreach ($categories as $cat)
            <option value="{{ $cat->id }}" @if($product->category_id==$cat->id) selected @endif>{{ $cat->name }}</option>
        @endforeach
    </select><br><br>

    <h3>Variants (Size + Color + Stock)</h3>
    <div id="variants">
        @foreach ($product->variants as $i => $v)
            <div class="variant">
                <input name="variants[{{ $i }}][size]" value="{{ $v['size'] ?? '' }}" placeholder="Size">
                <input name="variants[{{ $i }}][color]" value="{{ $v['color'] }}" placeholder="Color">
                <input name="variants[{{ $i }}][stock]" type="number" value="{{ $v['stock'] }}">
            </div>
        @endforeach
    </div>
    <button type="button" onclick="addVariant()">+ Thêm variant</button><br><br>

    <button>Cập nhật</button>
</form>

<a href="{{ route('admin.products.index') }}">← Quay lại</a>

<script>
let count = {{ count($product->variants) }};
function addVariant() {
    const container = document.getElementById('variants');
    const div = document.createElement('div');
    div.classList.add('variant');
    div.innerHTML = `
        <input name="variants[${count}][size]" placeholder="Size">
        <input name="variants[${count}][color]" placeholder="Color">
        <input name="variants[${count}][stock]" placeholder="Stock" type="number">
    `;
    container.appendChild(div);
    count++;
}
</script>
