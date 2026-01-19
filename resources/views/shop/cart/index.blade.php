@extends('shop.layouts.app')

@section('title','Giỏ hàng')

@section('content')
<div class="container my-5">

<h3 class="mb-4">🛒 Giỏ hàng của bạn</h3>

@if(empty($cart))
    <div class="alert alert-info">
        Giỏ hàng đang trống
    </div>
@else

<form action="{{ route('checkout.index') }}" method="GET" id="cartForm">

<table class="table align-middle">
<thead>
<tr>
    <th width="40">
        <input type="checkbox" id="checkAll">
    </th>
    <th>Sản phẩm</th>
    <th>Size</th>
    <th>Giá</th>
    <th>Số lượng</th>
    <th>Tạm tính</th>
</tr>
</thead>

<tbody>
@foreach($cart as $key => $item)
<tr data-price="{{ $item['price'] }}">

    {{-- CHECK --}}
    <td>
        <input type="checkbox"
               class="item-check"
               name="items[{{ $key }}][checked]"
               value="1">
    </td>

    {{-- HIDDEN DATA (QUAN TRỌNG) --}}
    <input type="hidden" name="items[{{ $key }}][product_id]" value="{{ $item['product_id'] ?? '' }}">
    <input type="hidden" name="items[{{ $key }}][name]" value="{{ $item['name'] }}">
    <input type="hidden" name="items[{{ $key }}][price]" value="{{ $item['price'] }}">

    {{-- PRODUCT --}}
    <td>
        <div class="d-flex align-items-center gap-3">
            @if(!empty($item['image']))
                <img
                    src="{{ asset('storage/'.$item['image']) }}"
                    width="70"
                    class="rounded border"
                >
            @else
                <img
                    src="https://via.placeholder.com/70x70?text=No+Image"
                    width="70"
                    class="rounded border"
                >
            @endif
            <strong>{{ $item['name'] }}</strong>
        </div>
    </td>

    {{-- SIZE --}}
    <td>
        <select name="items[{{ $key }}][size]" class="form-select form-select-sm">
            @foreach(['S','M','L','XL'] as $size)
                <option value="{{ $size }}"
                    {{ ($item['size'] ?? 'M') == $size ? 'selected' : '' }}>
                    {{ $size }}
                </option>
            @endforeach
        </select>
    </td>

    {{-- PRICE --}}
    <td>
        {{ number_format($item['price']) }} đ
    </td>

    {{-- QTY --}}
    <td>
        <div class="input-group input-group-sm" style="width:130px">
            <button type="button" class="btn btn-outline-secondary btn-minus">−</button>

            <input type="number"
                   name="items[{{ $key }}][qty]"
                   value="{{ $item['qty'] }}"
                   min="1"
                   class="form-control text-center qty-input">

            <button type="button" class="btn btn-outline-secondary btn-plus">+</button>
        </div>
    </td>

    {{-- SUBTOTAL --}}
    <td class="subtotal text-danger fw-bold">
        {{ number_format($item['price'] * $item['qty']) }} đ
    </td>

</tr>
@endforeach
</tbody>
</table>

{{-- FOOTER --}}
<div class="d-flex justify-content-between align-items-center mt-4">

    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
        ← Tiếp tục mua hàng
    </a>

    <div class="text-end">
        <h5>
            Tổng tiền:
            <span id="totalPrice" class="text-danger">0 đ</span>
        </h5>

        <button type="submit" class="btn btn-danger px-4 mt-2">
            Thanh toán →
        </button>
    </div>

</div>

</form>
@endif

</div>

{{-- ================= JS ================= --}}
<script>
function formatMoney(n){
    return new Intl.NumberFormat('vi-VN').format(n) + ' đ';
}

function updateTotal(){
    let total = 0;

    document.querySelectorAll('tbody tr').forEach(row => {
        const checked = row.querySelector('.item-check').checked;
        if(!checked) return;

        const price = Number(row.dataset.price);
        const qty   = Number(row.querySelector('.qty-input').value);

        total += price * qty;
    });

    document.getElementById('totalPrice').innerText = formatMoney(total);
}

// CHECK ALL
document.getElementById('checkAll').addEventListener('change', function(){
    document.querySelectorAll('.item-check').forEach(cb => {
        cb.checked = this.checked;
    });
    updateTotal();
});

// ITEM CHECK
document.querySelectorAll('.item-check').forEach(cb => {
    cb.addEventListener('change', updateTotal);
});

// PLUS
document.querySelectorAll('.btn-plus').forEach(btn => {
    btn.addEventListener('click', function(){
        const input = this.closest('td').querySelector('.qty-input');
        input.value = Number(input.value) + 1;
        input.dispatchEvent(new Event('change'));
    });
});

// MINUS
document.querySelectorAll('.btn-minus').forEach(btn => {
    btn.addEventListener('click', function(){
        const input = this.closest('td').querySelector('.qty-input');
        if(input.value > 1){
            input.value = Number(input.value) - 1;
            input.dispatchEvent(new Event('change'));
        }
    });
});

// QTY CHANGE
document.querySelectorAll('.qty-input').forEach(input => {
    input.addEventListener('change', function(){
        const row = this.closest('tr');
        const price = Number(row.dataset.price);
        const qty   = Number(this.value);

        row.querySelector('.subtotal').innerText =
            formatMoney(price * qty);

        updateTotal();
    });
});
</script>
@endsection
