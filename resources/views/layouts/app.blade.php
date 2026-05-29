<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Estrella Boutique')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }
    </style>
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
