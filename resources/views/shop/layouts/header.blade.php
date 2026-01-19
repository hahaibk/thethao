<header>

{{-- ================= TOP BAR ================= --}}
<div style="background:#000;color:#fff;font-size:13px;">
    <div class="container d-flex justify-content-between py-1">
        <span>Li-Ning Official Store</span>
        <span>Hotline: 1900 xxxx</span>
    </div>
</div>

{{-- ================= NAV ================= --}}
<nav class="navbar navbar-expand-lg bg-white border-bottom">
<div class="container">

{{-- LOGO --}}
<a class="navbar-brand" href="{{ route('home') }}">
    <img src="{{ asset('images/logo.png') }}" style="height:45px">
</a>

<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
    <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="menu">

<ul class="navbar-nav mx-auto text-uppercase fw-semibold gap-lg-3">

{{-- ===== MÔN THỂ THAO ===== --}}
<li class="nav-item dropdown simple-dropdown">
    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
        Môn thể thao
    </a>
    <ul class="dropdown-menu simple-menu">
        @foreach($sports as $sport)
            <li>
                <a class="dropdown-item"
                   href="{{ route('home',['sport'=>$sport->id]) }}">
                    {{ strtoupper($sport->name) }}
                </a>
            </li>
        @endforeach
    </ul>
</li>

{{-- ===== NAM ===== --}}
<li class="nav-item dropdown simple-dropdown">
    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
        Nam
    </a>
    <ul class="dropdown-menu simple-menu">
        @foreach($sports as $sport)
            <li>
                <a class="dropdown-item"
                   href="{{ route('home',['sport'=>$sport->id,'gender'=>'nam']) }}">
                    {{ strtoupper($sport->name) }}
                </a>
            </li>
        @endforeach
    </ul>
</li>

{{-- ===== NỮ ===== --}}
<li class="nav-item dropdown simple-dropdown">
    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
        Nữ
    </a>
    <ul class="dropdown-menu simple-menu">
        @foreach($sports as $sport)
            <li>
                <a class="dropdown-item"
                   href="{{ route('home',['sport'=>$sport->id,'gender'=>'nu']) }}">
                    {{ strtoupper($sport->name) }}
                </a>
            </li>
        @endforeach
    </ul>
</li>

{{-- ===== SALE ===== --}}
<li class="nav-item dropdown simple-dropdown">
    <a class="nav-link dropdown-toggle text-danger fw-bold" data-bs-toggle="dropdown">
        SALE %
    </a>
    <ul class="dropdown-menu simple-menu">
        @isset($activePromotions)
            @forelse($activePromotions as $promo)
                <li>
                    <a class="dropdown-item text-danger fw-semibold"
                       href="{{ route('promotions.index',['promotion'=>$promo->id]) }}">
                        🔥 GIẢM {{ $promo->discount_percent }}% – {{ strtoupper($promo->name) }}
                    </a>
                </li>
            @empty
                <li class="dropdown-item text-muted">
                    Hiện chưa có khuyến mại
                </li>
            @endforelse
        @endisset
    </ul>
</li>

{{-- ===== TIN TỨC ===== --}}
<li class="nav-item dropdown simple-dropdown">
    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
        Tin tức
    </a>
    <ul class="dropdown-menu simple-menu">
        <li><a class="dropdown-item" href="{{ route('events.index') }}">Sự kiện</a></li>
        <li><a class="dropdown-item" href="{{ route('promotions.index') }}">Khuyến mại</a></li>
    </ul>
</li>

</ul>

{{-- ================= SEARCH + ICON ================= --}}
<div class="d-flex align-items-center gap-3">

    {{-- SEARCH --}}
    <form action="{{ route('home') }}" method="GET">
        <input type="text"
               name="q"
               value="{{ request('q') }}"
               class="form-control form-control-sm"
               placeholder="Tìm sản phẩm..."
               style="width:180px">
    </form>

    {{-- CART --}}
    <a href="{{ route('cart.index') }}"
       style="font-size:18px;text-decoration:none">
        🛒
    </a>

    {{-- ================= USER ================= --}}
    @auth
        <div class="dropdown">
            <a class="d-flex align-items-center gap-2 dropdown-toggle"
               data-bs-toggle="dropdown"
               style="cursor:pointer;text-decoration:none;color:#000">
                <img src="{{ asset('images/user.png') }}"
                     style="width:32px;height:32px;border-radius:50%">
            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow">
                <li class="px-3 py-2 fw-bold">
                    👤 {{ auth()->user()->name }}
                </li>
                <li><hr class="dropdown-divider"></li>

                <li>
                    <a class="dropdown-item" href="{{ route('orders.index') }}">
                        📦 Lịch sử mua hàng
                    </a>
                </li>

                <li>
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        ⚙️ Thông tin tài khoản
                    </a>
                </li>

                <li><hr class="dropdown-divider"></li>

                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item text-danger">
                            🚪 Đăng xuất
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    @else
        <a href="{{ route('login') }}" class="btn btn-outline-dark btn-sm">
            Đăng nhập
        </a>
    @endauth

</div>

</div>
</div>
</nav>

{{-- ================= CSS ================= --}}
<style>
.navbar .nav-link{
    padding:22px 14px;
}

.simple-dropdown{ position:relative; }

.simple-menu{
    min-width:220px;
    padding:8px 0;
    border:1px solid #eee;
    box-shadow:0 8px 25px rgba(0,0,0,.12);
}

.simple-menu .dropdown-item{
    padding:10px 18px;
    font-size:14px;
    font-weight:500;
}

.simple-menu .dropdown-item:hover{
    background:#f5f5f5;
    color:#d70000;
    font-weight:600;
}

.navbar-nav > li.dropdown:hover > .dropdown-menu{
    display:block;
}
</style>

</header>
