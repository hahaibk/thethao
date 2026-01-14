<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Dashboard')</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
            font-size: 14px;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 240px;
            background: linear-gradient(180deg, #1f2937, #111827);
            color: #fff;
            padding: 20px 15px;
        }

        .sidebar h2 {
            font-size: 18px;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 600;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            color: #e5e7eb;
            text-decoration: none;
            border-radius: 6px;
            margin-bottom: 6px;
            transition: all 0.2s ease;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #2563eb;
            color: #fff;
        }

        /* Submenu */
        .submenu {
            margin-left: 10px;
            margin-top: 5px;
        }

        .submenu a {
            font-size: 13px;
            background: #1f2937;
        }

        .submenu a:hover,
        .submenu a.active {
            background: #1d4ed8;
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
            padding: 12px 20px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* ===== CONTENT ===== */
        .content {
            padding: 20px;
            flex: 1;
        }

        /* ===== FOOTER ===== */
        .footer {
            background: #fff;
            padding: 10px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            font-size: 13px;
            color: #6b7280;
        }
    </style>
</head>
<body>

<div class="admin-wrapper">

    {{-- SIDEBAR --}}
    <aside class="sidebar">
        <h2>ADMIN PANEL</h2>

        <a href="{{ route('admin.dashboard') }}"
           class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        {{-- HOME SECTION --}}
        <a href="javascript:void(0)" id="home-menu-toggle"
           class="{{ request()->routeIs('admin.homesection.*') ? 'active' : '' }}">
            <i class="bi bi-images"></i> Trang chủ
        </a>

        <div id="home-submenu" class="submenu"
             style="display: {{ request()->routeIs('admin.homesection.*') ? 'block' : 'none' }}">
            <a href="{{ route('admin.homesection.banner.index') }}">
                <i class="bi bi-image"></i> Banner
            </a>
            <a href="{{ route('admin.homesection.events.index') }}">
                <i class="bi bi-calendar-event"></i> Event
            </a>
            <a href="{{ route('admin.homesection.sales.index') }}"
                class="{{ request()->routeIs('admin.homesection.sales.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i> Sale
            </a>
        </div>

        <hr class="border-secondary">

        <a href="{{ route('admin.products.index') }}">
            <i class="bi bi-bag"></i> Sản phẩm
        </a>

        <a href="{{ route('admin.categories.index') }}">
            <i class="bi bi-folder"></i> Loại sản phẩm
        </a>

        <a href="{{ route('admin.users.index') }}">
            <i class="bi bi-people"></i> Users
        </a>

        <hr class="border-secondary">

        <a href="{{ route('home') }}">
            <i class="bi bi-globe"></i> Về website
        </a>
    </aside>

    {{-- MAIN --}}
    <div class="main">

        {{-- HEADER --}}
        <header class="header">
            <strong>@yield('page-title', 'Dashboard')</strong>

            <div class="d-flex align-items-center gap-2">
                <span class="text-muted">{{ auth()->user()->name ?? 'Admin' }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger">Đăng xuất</button>
                </form>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="content">
            @yield('content')
        </main>

        {{-- FOOTER --}}
        <footer class="footer">
            © {{ date('Y') }} Admin Panel
        </footer>

    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- Toggle submenu --}}
<script>
    document.getElementById('home-menu-toggle')?.addEventListener('click', function () {
        const submenu = document.getElementById('home-submenu');
        submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
    });
</script>

@yield('scripts')
</body>
</html>
