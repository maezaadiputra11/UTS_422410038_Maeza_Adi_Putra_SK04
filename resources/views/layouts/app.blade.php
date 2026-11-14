<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Arsip Pita Analog') | Studio Restorasi Pita</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>
    @include('partials.navbar')

    <div class="app-shell">
        @include('partials.sidebar')

        <main class="main-content">
            @if (session('success'))
                <x-alert type="success">{{ session('success') }}</x-alert>
            @endif
            @if (session('error'))
                <x-alert type="danger">{{ session('error') }}</x-alert>
            @endif

            @yield('content')
        </main>
    </div>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>
