<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Dashboard')</title>

    {{-- CSS --}}
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 220px;
            background: #2c3e50;
            color: #fff;
            padding: 20px;
        }

        .sidebar h2 {
            font-size: 18px;
            margin-bottom: 20px;
            text-align: center;
        }

        .sidebar a {
            display: block;
            padding: 10px;
            color: #ecf0f1;
            text-decoration: none;
            border-radius: 4px;
            margin-bottom: 5px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #1abc9c;
        }

        /* ===== MAIN ===== */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* ===== HEADER ===== */
        .header {
            background: #fff;
            padding: 15px 20px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* ===== CONTENT ===== */
        .content {
            padding: 20px;
            background: #f4f6f9;
            flex: 1;
        }

        /* ===== FOOTER ===== */
        .footer {
            background: #fff;
            padding: 10px;
            text-align: center;
            border-top: 1px solid #ddd;
            font-size: 13px;
        }
    </style>
</head>
<body>

<div class="admin-wrapper">

    {{-- SIDEBAR --}}
    <div class="sidebar">
        <h2>ADMIN</h2>

        <a href="{{ route('admin.dashboard') }}"
           class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            🏠 Dashboard
        </a>

        <a href="{{ route('admin.products.index') }}"
           class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            👕 Sản phẩm
        </a>

        <a href="{{ route('admin.categories.index') }}"
           class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            📂 Loại sản phẩm
        </a>

        <a href="{{ route('admin.users.index') }}"
           class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            👤 Users
        </a>

        <hr>

        <a href="{{ route('home') }}">🌐 Về website</a>
    </div>

    {{-- MAIN --}}
    <div class="main">

        {{-- HEADER --}}
        <div class="header">
            <div>
                <strong>@yield('page-title', 'Dashboard')</strong>
            </div>

            <div>
                {{ auth()->user()->name ?? 'Admin' }}
                |
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Đăng xuất
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="content">
            @yield('content')
        </div>

        {{-- FOOTER --}}
        <div class="footer">
            © {{ date('Y') }} Admin Panel
        </div>

    </div>

</div>

@yield('scripts')

</body>
</html>
