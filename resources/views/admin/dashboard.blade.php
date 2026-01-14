@extends('admin.layout')

@section('content')
<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📊 Dashboard</h2>
    </div>

    <!-- LINK NHANH -->
    <div class="mb-4">
        <a href="{{ route('admin.products.index') }}" class="btn btn-primary me-2">
            👕 Quản lý sản phẩm
        </a>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-success">
            📂 Quản lý loại
        </a>
    </div>

    <!-- THỐNG KÊ -->
    <div class="row g-4">
        <div class="col-sm-6 col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Sản phẩm</h5>
                    <p class="card-text display-6 fw-bold">{{ $totalProducts }}</p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Danh mục</h5>
                    <p class="card-text display-6 fw-bold">{{ $totalCategories }}</p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Người dùng</h5>
                    <p class="card-text display-6 fw-bold">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="card text-center shadow-sm border-success">
                <div class="card-body">
                    <h5 class="card-title">Tồn kho</h5>
                    <p class="card-text display-6 fw-bold text-success">{{ $totalStock }}</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
