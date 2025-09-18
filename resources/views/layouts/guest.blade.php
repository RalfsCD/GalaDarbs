<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PostPit</title>

    <!-- Favicon (logo in tab) -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">

    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-900">

    @yield('content')

    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
