<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PostPit') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpeg">

    <!-- ✅ Prevent dark/light flicker -->
    <script>
        (function() {
            const theme = localStorage.getItem("color-theme");
            if (theme === "dark" || (!theme && window.matchMedia("(prefers-color-scheme: dark)").matches)) {
                document.documentElement.classList.add("dark");
            } else {
                document.documentElement.classList.remove("dark");
            }
        })();
    </script>

    @vite('resources/css/app.css')

    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">
    {{-- Navbar --}}
    @include('layouts.navigation')

    <div class="flex min-h-screen">
        {{-- Sidebar (optional) --}}
        @hasSection('sidebar')
            <aside class="hidden sm:block fixed top-16 left-0 w-56 h-full bg-gray-50 dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700">
                @yield('sidebar')
            </aside>
        @endif

        {{-- Main content --}}
        <main class="flex-1 sm:ml-56 pt-16 px-4 sm:px-6 lg:px-8 transition-all duration-300">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- Scripts --}}
    @yield('scripts')

    <!-- ✅ Dark Mode Toggle Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const html = document.documentElement;

            function setupToggle(lightIconId, darkIconId, btnId) {
                const lightIcon = document.getElementById(lightIconId);
                const darkIcon = document.getElementById(darkIconId);
                const btn = document.getElementById(btnId);

                if (!btn) return;

                // Set icons initially
                if (html.classList.contains("dark")) {
                    lightIcon?.classList.remove("hidden");
                } else {
                    darkIcon?.classList.remove("hidden");
                }

                // Toggle on click
                btn.addEventListener("click", function () {
                    darkIcon?.classList.toggle("hidden");
                    lightIcon?.classList.toggle("hidden");

                    if (html.classList.contains("dark")) {
                        html.classList.remove("dark");
                        localStorage.setItem("color-theme", "light");
                    } else {
                        html.classList.add("dark");
                        localStorage.setItem("color-theme", "dark");
                    }
                });
            }

            // Apply to both desktop + mobile buttons
            setupToggle("theme-toggle-light-icon", "theme-toggle-dark-icon", "theme-toggle");
            setupToggle("theme-toggle-light-icon-mobile", "theme-toggle-dark-icon-mobile", "theme-toggle-mobile");
        });
    </script>
</body>
</html>
