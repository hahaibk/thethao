@extends('admin.layout')

@section('title', 'Quản lý hóa đơn')

@section('content')
<div class="container-fluid">

    <h4 class="mb-3">📦 Danh sách đơn hàng</h4>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Khách hàng</th>
                <th>Email</th>
                <th>Tổng tiền</th>
                <th>Thanh toán</th>
                <th>Trạng thái</th>
                <th>Ngày</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->user->email }}</td>
                <td>{{ number_format($order->total_price) }} đ</td>
                <td>{{ $order->payment_method }}</td>
                <td>
                    <span class="badge bg-success">
                        {{ $order->status }}
                    </span>
                </td>
                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $order) }}"
                       class="btn btn-sm btn-primary">
                        Xem
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $orders->links() }}

</div>
@endsection
