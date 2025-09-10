<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite('resources/css/app.css')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100 text-gray-900">

    {{-- Navbar --}}
    @include('layouts.navigation')

    <div class="min-h-screen flex">
        {{-- Sidebar (optional) --}}
        @hasSection('sidebar')
            <aside class="hidden sm:block fixed top-16 left-0 w-56 h-full bg-gray-50 border-r border-gray-200">
                @yield('sidebar')
            </aside>
        @endif

        {{-- Main content --}}
        <main class="flex-1 py-6 px-4 sm:px-6 lg:px-8 pt-16">
            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>
</html>
