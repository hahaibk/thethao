<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','Li-Ning Vietnam')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            color: #111;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .text-brand { color: #e60012; }
        .bg-brand { background: #e60012; }

        .btn-brand {
            background: #e60012;
            color: #fff;
            border-radius: 0;
            font-weight: 600;
        }

        .btn-brand:hover {
            background: #111;
            color: #fff;
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('js')
</body>
</html>
