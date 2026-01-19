@extends('admin.layout')

@section('title', 'Chi tiết hóa đơn')

@section('content')
<div class="container-fluid">

    <h4>🧾 Hóa đơn #{{ $order->id }}</h4>
    <hr>

    <div class="row mb-3">
        <div class="col-md-6">
            <p><b>Khách hàng:</b> {{ $order->user->name }}</p>
            <p><b>Email:</b> {{ $order->user->email }}</p>
            <p><b>Ngày mua:</b> {{ $order->created_at }}</p>
        </div>
        <div class="col-md-6">
            <p><b>Thanh toán:</b> {{ $order->payment_method }}</p>
            <p><b>Trạng thái:</b>
                <span class="badge bg-success">{{ $order->status }}</span>
            </p>
        </div>
    </div>

    <table class="table table-bordered">
        <thead class="table-secondary">
            <tr>
                <th>Sản phẩm</th>
                <th>SL</th>
                <th>Giá</th>
                <th>Tạm tính</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price) }} đ</td>
                <td>{{ number_format($item->price * $item->quantity) }} đ</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h5 class="text-end">
        Tổng tiền:
        <span class="text-danger">
            {{ number_format($order->total_price) }} đ
        </span>
    </h5>

</div>
@endsection
