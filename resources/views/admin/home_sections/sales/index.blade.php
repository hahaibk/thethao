@extends('admin.layout')

@section('title', 'Quản lý Sale')
@section('page-title', 'Sale / Khuyến mãi')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-tags"></i> Danh sách Sale
        </h4>

        <a href="{{ route('admin.homesection.sales.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Thêm Sale
        </a>
    </div>

    {{-- Card --}}
    <div class="card shadow-sm">
        <div class="card-header">
            <strong>Sale hiện có</strong>
        </div>

        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-dark">
                <tr>
                    <th width="60">#</th>
                    <th>Tiêu đề</th>
                    <th>Ảnh</th>
                    <th>Mô tả ngắn</th>
                    <th width="140" class="text-center">Hành động</th>
                </tr>
                </thead>

                <tbody>
                @forelse($sales as $sale)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td class="fw-semibold">
                            {{ $sale->title }}
                        </td>

                        <td>
                            @if($sale->thumbnail)
                                <img src="{{ asset('storage/'.$sale->thumbnail) }}"
                                     class="img-thumbnail"
                                     width="90">
                            @else
                                <span class="text-muted fst-italic">Không ảnh</span>
                            @endif
                        </td>

                        <td>
                            {{ \Illuminate\Support\Str::limit(strip_tags($sale->content), 80) }}
                        </td>

                        <td class="text-center">
                            <a href="{{ route('admin.homesection.sales.edit', $sale->id) }}"
                               class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('admin.homesection.sales.destroy', $sale->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Xóa sale này?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            Chưa có Sale nào
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
