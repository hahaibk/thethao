@extends('admin.layout')

@section('content')
<div class="product-page">

    <!-- HEADER -->
    <div class="page-header">
        <h1>📦 Danh sách sản phẩm</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-add">+ Thêm sản phẩm</a>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Danh sách sản phẩm</h4>

        <a href="{{ route('admin.products.featured') }}"
           class="btn btn-warning">
            ⭐ Quản lý sản phẩm nổi bật
        </a>
    </div>

    <!-- FILTER -->
    <form class="filter-box" method="GET">
        <input type="text"
               name="q"
               placeholder="🔍 Tìm theo tên sản phẩm..."
               value="{{ request('q') }}">

        <select name="category_id">
            <option value="">— Tất cả danh mục —</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}"
                    {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-filter">Lọc</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-reset">Reset</a>
    </form>

    <!-- TABLE -->
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên</th>
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Biến thể</th>
                    <th>Tồn kho</th>
                    <th>Nổi bật</th>
                    <th width="180">Hành động</th>
                </tr>
            </thead>
            <tbody>
            @forelse($products as $product)
                @php $thumb = $product->images->first(); @endphp
                <tr>
                    <td>
                        <div class="thumb">
                            @if($thumb)
                                <img src="{{ asset('storage/'.$thumb->image_path) }}">
                            @endif
                        </div>
                    </td>

                    <td class="name">{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? '—' }}</td>
                    <td class="price">{{ number_format($product->price,0,',','.') }}₫</td>
                    <td>{{ $product->variants_count }}</td>
                    <td>{{ $product->totalStock() }}</td>

                    <!-- ⭐ FEATURED -->
                    <td>
                        <form action="{{ route('admin.products.featured.toggle', $product) }}"
                              method="POST">
                            @csrf
                            <button type="submit"
                                class="btn-featured {{ $product->is_featured ? 'on' : 'off' }}"
                                title="Bật / tắt sản phẩm nổi bật">
                                {{ $product->is_featured ? '⭐' : '☆' }}
                            </button>
                        </form>
                    </td>

                    <!-- ACTIONS -->
                    <td class="actions">
                        <a href="{{ route('admin.products.show',$product) }}" class="btn view">Xem</a>
                        <a href="{{ route('admin.products.edit',$product) }}" class="btn edit">Sửa</a>
                        <form action="{{ route('admin.products.destroy',$product) }}"
                              method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button class="btn delete"
                                onclick="return confirm('Xóa sản phẩm?')">
                                Xóa
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="empty">Không có sản phẩm</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="pagination">
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>

<style>
.product-page{max-width:1300px;margin:25px auto;font-family:Arial}
.page-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px}
.page-header h1{font-size:22px}
.filter-box{display:flex;gap:10px;margin-bottom:15px;background:#f9f9f9;padding:12px;border-radius:8px}
.filter-box input,.filter-box select{padding:8px 10px;border:1px solid #ddd;border-radius:6px}

.table-wrapper{background:#fff;border-radius:10px;overflow:hidden}
table{width:100%;border-collapse:collapse}
th{background:#f1f1f1;padding:12px}
td{padding:10px;text-align:center;border-top:1px solid #eee}
td.name{text-align:left}

.thumb{width:60px;height:60px;border-radius:8px;overflow:hidden;background:#eee;margin:auto}
.thumb img{width:100%;height:100%;object-fit:cover}

.price{color:#e74c3c;font-weight:bold}

.actions{display:flex;gap:6px;justify-content:center}
.btn{padding:6px 10px;border-radius:5px;color:#fff;text-decoration:none;border:none}
.btn-add{background:#2ecc71}
.btn-filter{background:#3498db}
.btn-reset{background:#95a5a6}
.btn.view{background:#3498db}
.btn.edit{background:#f1c40f;color:#000}
.btn.delete{background:#e74c3c}

.btn-featured{
    background:transparent;
    border:none;
    font-size:20px;
    cursor:pointer;
    padding:4px 8px;
}
.btn-featured.on{color:#f1c40f}
.btn-featured.off{color:#ccc}
.btn-featured:hover{transform:scale(1.2)}

.empty{padding:20px;color:#999}

.pagination{margin-top:15px;display:flex;justify-content:center}
.pagination nav ul{display:flex;gap:5px;list-style:none;padding:0}
.pagination nav ul li a,
.pagination nav ul li span{
    padding:6px 12px;
    border:1px solid #ddd;
    border-radius:4px;
    text-decoration:none;
    color:#333;
}
.pagination nav ul li.active span{
    background:#3498db;
    color:#fff;
    border-color:#3498db;
}
</style>
@endsection
