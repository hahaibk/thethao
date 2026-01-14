@extends('admin.layout')

@section('title', 'Sản phẩm nổi bật')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">🌟 Sản phẩm nổi bật</h3>
            <p class="text-muted mb-0">Quản lý sản phẩm hiển thị ngoài trang chủ</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
            ← Quay lại sản phẩm
        </a>
    </div>

    {{-- FLASH --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- TABLE --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="60">#</th>
                        <th>Ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Giá</th>
                        <th class="text-center">Nổi bật</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>

                            {{-- IMAGE --}}
                            <td>
                                @if($product->images->first())
                                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                         class="rounded border"
                                         width="60" height="60"
                                         style="object-fit: cover">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>

                            {{-- NAME --}}
                            <td>
                                <div class="fw-semibold">{{ $product->name }}</div>
                                <small class="text-muted">ID: {{ $product->id }}</small>
                            </td>

                            {{-- CATEGORY --}}
                            <td>
                                <span class="badge bg-light text-dark">
                                    {{ $product->category->name ?? '---' }}
                                </span>
                            </td>

                            {{-- PRICE --}}
                            <td class="fw-bold text-danger">
                                {{ number_format($product->price) }} ₫
                            </td>

                            {{-- STATUS --}}
                            <td class="text-center">
                                @if($product->is_featured)
                                    <span class="badge bg-success">
                                        Đang nổi bật
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        Không
                                    </span>
                                @endif
                            </td>

                            {{-- ACTION --}}
                            <td class="text-end">
                                <form action="{{ route('admin.products.featured.toggle', $product) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('PATCH')

                                    <button class="btn btn-sm
                                        {{ $product->is_featured ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                        {{ $product->is_featured ? 'Bỏ nổi bật' : 'Đặt nổi bật' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Không có sản phẩm nổi bật
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-4">
        {{ $products->links() }}
    </div>

</div>
@endsection
