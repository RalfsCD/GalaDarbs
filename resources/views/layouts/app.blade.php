<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-black text-white">
    <div class="min-h-screen">
        @include('layouts.navigation') {{-- navbar --}}
        <header>{{ $header ?? '' }}</header>

       <main class="py-6 px-4 sm:px-6 lg:px-8 mt-16">
    @yield('content')
</main>
    </div>
</body>
</html>
