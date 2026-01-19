@extends('admin.layout')

@section('page-title', 'Khuyến mãi')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Danh sách khuyến mãi</h4>

        <a href="{{ route('admin.promotions.create') }}"
           class="btn btn-danger">
            <i class="bi bi-plus-circle"></i> Thêm khuyến mãi
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tên</th>
                        <th>Giảm</th>
                        <th>Thời gian</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($promotions as $p)
                        <tr>
                            <td class="fw-semibold">{{ $p->name }}</td>

                            <td>
                                {{ $p->type === 'percent'
                                    ? $p->value.'%'
                                    : number_format($p->value).'đ' }}
                            </td>

                            <td class="small text-muted">
                                {{ $p->start_at?->format('d/m/Y H:i') ?? '—' }}
                                →
                                {{ $p->end_at?->format('d/m/Y H:i') ?? '—' }}
                            </td>

                            <td>
                                @if($p->is_active && $p->isValid())
                                    <span class="badge bg-success">Đang chạy</span>
                                @elseif($p->is_active)
                                    <span class="badge bg-warning text-dark">Chưa tới hạn</span>
                                @else
                                    <span class="badge bg-secondary">Tắt</span>
                                @endif
                            </td>

                            <td class="text-end">
                                <a href="{{ route('admin.promotions.edit', $p) }}"
                                   class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form method="POST"
                                      action="{{ route('admin.promotions.destroy', $p) }}"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Xóa khuyến mãi này?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Chưa có khuyến mãi nào
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

    <div class="mt-3">
        {{ $promotions->links() }}
    </div>

</div>
@endsection
