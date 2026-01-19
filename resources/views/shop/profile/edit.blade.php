@extends('shop.layouts.app')

@section('title','Chỉnh sửa tài khoản')

@section('content')
<div class="container my-5" style="max-width:700px">

    <h3 class="fw-bold mb-4">
        👤 Chỉnh sửa thông tin tài khoản
    </h3>

    {{-- THÔNG BÁO --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM --}}
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf

        {{-- TÊN --}}
        <div class="mb-3">
            <label class="form-label">Họ tên</label>
            <input
                type="text"
                name="name"
                class="form-control"
                value="{{ old('name', auth()->user()->name) }}"
                required
            >
        </div>

        {{-- EMAIL --}}
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input
                type="email"
                class="form-control"
                value="{{ auth()->user()->email }}"
                disabled
            >
            <small class="text-muted">
                Email không thể thay đổi
            </small>
        </div>

        <hr>

        <h6 class="fw-bold mt-4">🔐 Đổi mật khẩu (không bắt buộc)</h6>

        {{-- PASSWORD --}}
        <div class="mb-3">
            <label class="form-label">Mật khẩu mới</label>
            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Nhập nếu muốn đổi"
            >
        </div>

        {{-- CONFIRM --}}
        <div class="mb-4">
            <label class="form-label">Xác nhận mật khẩu</label>
            <input
                type="password"
                name="password_confirmation"
                class="form-control"
            >
        </div>

        {{-- BUTTON --}}
        <div class="d-flex gap-2">
            <button class="btn btn-dark px-4">
                💾 Lưu thay đổi
            </button>

            <a href="{{ route('profile.index') }}" class="btn btn-outline-secondary">
                Quay lại
            </a>
        </div>
    </form>

</div>
@endsection
