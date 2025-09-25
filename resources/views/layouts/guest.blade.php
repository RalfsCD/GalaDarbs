<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PostPit</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">

    {{-- Prevent dark/light flicker (set theme before paint) --}}
    <script>
      (function() {
        try {
          const pref = localStorage.getItem('color-theme');
          const shouldDark = pref ? (pref === 'dark')
                                  : window.matchMedia('(prefers-color-scheme: dark)').matches;
          if (shouldDark) document.documentElement.classList.add('dark');
          else document.documentElement.classList.remove('dark');
        } catch (e) {}
      })();
    </script>

    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 transition-colors duration-300">
    @yield('content')

    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
