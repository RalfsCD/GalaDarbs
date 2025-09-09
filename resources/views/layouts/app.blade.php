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
<body class="bg-black text-white">
    {{-- Navbar (always visible, fixed at top) --}}
    @include('layouts.navigation')

    <div class="min-h-screen flex">
        {{-- Sidebar (optional, only if section exists) --}}
        @hasSection('sidebar')
            <aside class="hidden sm:block fixed top-16 left-0 w-56 h-full bg-gray-900 border-r border-gray-700">
                @yield('sidebar')
            </aside>
        @endif

        {{-- Main content (with dynamic left margin) --}}
        <main class="flex-1 py-6 px-4 sm:px-6 lg:px-8 pt-16 @yield('main-classes')">
            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>
</html>
