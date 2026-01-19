@extends('shop.layouts.app')

@section('title', 'Đơn hàng của tôi')

@section('content')
<div class="container py-4">
    <h3>🧾 Đơn hàng đã mua</h3>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Mã đơn</th>
                <th>Ngày mua</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                    <td>{{ number_format($order->total_price) }} đ</td>
                    <td>
                        <span class="badge bg-success">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('orders.show', $order) }}"
                           class="btn btn-sm btn-primary">
                            Xem
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        Chưa có đơn hàng
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
