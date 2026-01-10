<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','Li-Ning Vietnam')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

    {{-- CSS riêng --}}
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
        a {
            text-decoration: none;
        }
    </style>

    @stack('css')
</head>
<body>

    @include('shop.layouts.header')

    <main>
        @yield('content')
    </main>

    @include('shop.layouts.footer')

    {{-- Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('js')
</body>
</html>
