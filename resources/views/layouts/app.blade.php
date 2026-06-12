<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'HOODIEL')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=block" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-background text-on-background antialiased">

    <!-- Memanggil komponen Navbar -->
   
    @if (request()->routeIs('admin') or request()->routeIs('admin-orders'))
        <div class="flex min-h-screen">
            @include('partials.sidebar')
            <main class="flex-1 min-w-0">
                @yield('content')
            </main>
            @stack('scripts')
        </div>
    @else
        @include('partials.navbar')
        <main class="min-w-0">
            @yield('content')
        </main>
        @include('partials.footer')
        @stack('scripts')
    @endif
</body>
</html>
