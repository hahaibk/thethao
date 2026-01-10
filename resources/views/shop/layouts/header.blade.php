<header class="border-bottom">
    {{-- TOP BAR --}}
    <div class="bg-black text-white py-1 small">
        <div class="container d-flex justify-content-between">
            <span>Li-Ning Official Store</span>
            <span>Hotline: 1900 xxxx</span>
        </div>
    </div>

    {{-- MAIN NAV --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">

            {{-- LOGO --}}
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <span style="color:red;">LI</span>-NING
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#mainMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- MENU --}}
            <div class="collapse navbar-collapse" id="mainMenu">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-4 fw-semibold">
                    <li class="nav-item"><a class="nav-link" href="#">NAM</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">NỮ</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">GIÀY</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">PHỤ KIỆN</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="#">SALE</a></li>
                </ul>

                {{-- ACTION --}}
                <div class="d-flex align-items-center gap-3">
                    <a href="#" class="text-dark">🔍</a>
                    <a href="#" class="text-dark">🛒</a>

                    @auth
                        <span class="small">{{ auth()->user()->name }}</span>

                        {{-- FORM ĐĂNG XUẤT --}}
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-dark btn-sm">
                                Đăng xuất
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-dark btn-sm">
                            Đăng nhập
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</header>
