@extends('shop.layouts.app')

@section('title','Thanh toán')

@section('content')
<div class="container my-5">

<h3 class="mb-4">💳 Thanh toán</h3>

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if(empty($items))
    <div class="alert alert-warning">
        Không có sản phẩm nào được chọn để thanh toán
    </div>
@else

<form action="{{ route('checkout.store') }}" method="POST">
@csrf

{{-- ================= GIỮ DỮ LIỆU SẢN PHẨM ĐÃ CHỌN ================= --}}
@foreach($items as $key => $item)
    @if(isset($item['checked']))
        <input type="hidden" name="items[{{ $key }}][product_id]" value="{{ $item['product_id'] }}">
        <input type="hidden" name="items[{{ $key }}][name]" value="{{ $item['name'] }}">
        <input type="hidden" name="items[{{ $key }}][price]" value="{{ $item['price'] }}">
        <input type="hidden" name="items[{{ $key }}][qty]" value="{{ $item['qty'] }}">
        <input type="hidden" name="items[{{ $key }}][size]" value="{{ $item['size'] }}">
        <input type="hidden" name="items[{{ $key }}][checked]" value="1">
    @endif
@endforeach

<div class="row">

{{-- ================= THÔNG TIN KHÁCH ================= --}}
<div class="col-md-7">

<div class="card mb-4">
<div class="card-header fw-bold">📦 Thông tin nhận hàng</div>
<div class="card-body">

<div class="mb-3">
    <label class="form-label">Họ và tên</label>
    <input type="text" name="name" class="form-control" required>
</div>

<div class="mb-3">
    <label class="form-label">Số điện thoại</label>
    <input type="text" name="phone" class="form-control" required>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Tỉnh / Thành</label>
        <select id="province" name="province" class="form-select" required>
            <option value="">-- Chọn tỉnh --</option>
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Quận / Huyện</label>
        <select id="district" name="district" class="form-select" required>
            <option value="">-- Chọn quận --</option>
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Phường / Xã</label>
        <select id="ward" name="ward" class="form-select" required>
            <option value="">-- Chọn phường --</option>
        </select>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Địa chỉ chi tiết</label>
    <input type="text" name="address" class="form-control"
           placeholder="Số nhà, tên đường..." required>
</div>

</div>
</div>

{{-- ================= THANH TOÁN ================= --}}
<div class="card">
<div class="card-header fw-bold">💰 Phương thức thanh toán</div>
<div class="card-body">

<div class="form-check mb-2">
    <input class="form-check-input" type="radio"
           name="payment_method" value="cod" checked>
    <label class="form-check-label">
        Thanh toán khi nhận hàng (COD)
    </label>
</div>

<div class="form-check">
    <input class="form-check-input" type="radio"
           name="payment_method" value="bank">
    <label class="form-check-label">
        Chuyển khoản ngân hàng / Thẻ
    </label>
</div>

<div class="alert alert-info mt-3">
    💳 Ngân hàng: <b>VCB</b><br>
    💳 STK: <b>0123 456 789</b><br>
    💳 Chủ TK: <b>LI-NING STORE</b>
</div>

</div>
</div>

</div>

{{-- ================= ĐƠN HÀNG ================= --}}
<div class="col-md-5">

<div class="card">
<div class="card-header fw-bold">🛒 Sản phẩm đã chọn</div>
<div class="card-body p-0">

<table class="table mb-0">
<thead class="table-light">
<tr>
    <th>Sản phẩm</th>
    <th>Size</th>
    <th>SL</th>
</tr>
</thead>
<tbody>

@php $total = 0; @endphp

@foreach($items as $item)
    @if(isset($item['checked']))
    <tr>
        <td>
            {{ $item['name'] }}
            <br>
            <small class="text-muted">
                {{ number_format($item['price']) }}đ
            </small>
        </td>
        <td>{{ $item['size'] }}</td>
        <td>{{ $item['qty'] }}</td>
    </tr>
    @php $total += $item['price'] * $item['qty']; @endphp
    @endif
@endforeach

</tbody>
</table>

</div>

<div class="card-footer">
    <div class="d-flex justify-content-between fw-bold mb-3">
        <span>Tổng tiền:</span>
        <span class="text-danger">
            {{ number_format($total) }}đ
        </span>
    </div>

    <button type="submit" class="btn btn-danger w-100 py-2 fw-bold">
        🚀 Thanh toán ngay
    </button>

    <a href="{{ route('cart.index') }}"
       class="btn btn-link w-100 mt-2">
        ← Quay lại giỏ hàng
    </a>
</div>

</div>

</div>
</div>

</form>

@endif

</div>

{{-- ================= JS ĐỊA GIỚI HÀNH CHÍNH ================= --}}
<script>
const host = "https://provinces.open-api.vn/api/";

fetch(host + "?depth=1")
.then(res => res.json())
.then(data => {
    data.forEach(p => {
        province.innerHTML +=
        `<option value="${p.name}" data-id="${p.code}">${p.name}</option>`;
    });
});

province.addEventListener("change", function(){
    let code = this.options[this.selectedIndex].dataset.id;
    fetch(host + "p/" + code + "?depth=2")
    .then(res => res.json())
    .then(data => {
        district.innerHTML = '<option value="">-- Chọn quận --</option>';
        ward.innerHTML = '<option value="">-- Chọn phường --</option>';
        data.districts.forEach(d => {
            district.innerHTML +=
            `<option value="${d.name}" data-id="${d.code}">${d.name}</option>`;
        });
    });
});

district.addEventListener("change", function(){
    let code = this.options[this.selectedIndex].dataset.id;
    fetch(host + "d/" + code + "?depth=2")
    .then(res => res.json())
    .then(data => {
        ward.innerHTML = '<option value="">-- Chọn phường --</option>';
        data.wards.forEach(w => {
            ward.innerHTML += `<option value="${w.name}">${w.name}</option>`;
        });
    });
});
</script>

@endsection
