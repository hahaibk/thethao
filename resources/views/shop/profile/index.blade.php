@extends('shop.layouts.app')

@section('title','Tài khoản')

@section('content')
<div class="container my-5" style="max-width:600px">

<h4 class="mb-4">👤 Thông tin tài khoản</h4>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
<div class="card-body">

<p><b>Họ tên:</b> {{ $user->name }}</p>
<p><b>Email:</b> {{ $user->email }}</p>
<p><b>SĐT:</b> {{ $user->phone ?? 'Chưa cập nhật' }}</p>

<a href="{{ route('profile.edit') }}" class="btn btn-primary mt-3">
    ✏️ Chỉnh sửa thông tin
</a>

</div>
</div>

</div>
@endsection
