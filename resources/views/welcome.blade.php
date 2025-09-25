@extends('layouts.guest')

@section('content')
<main class="min-h-screen flex flex-col items-center justify-center space-y-12 px-4 bg-gray-50 dark:bg-gray-900">

    <!-- Logo (switches with theme) -->
    <div class="flex justify-center relative h-28">
        <img src="{{ asset('images/LogoDark.png') }}" 
             alt="PostPit Logo Light" 
             class="h-28 w-auto block dark:hidden">
        <img src="{{ asset('images/LogoWhite.png') }}" 
             alt="PostPit Logo Dark" 
             class="h-28 w-auto hidden dark:block">
    </div>

    <!-- Title -->
    <h1 class="text-5xl font-extrabold text-gray-900 dark:text-gray-100 text-center">
        Welcome to <span class="text-gray-400 dark:text-gray-300 inline-block">PostPit</span>
    </h1>

    <!-- Subtitle -->
    <p class="text-gray-400 dark:text-gray-300 text-center max-w-xl">
        Connect, Create & Explore communities with PostPit.
    </p>

    <!-- Auth Buttons -->
    <div class="flex space-x-6">
        <a href="{{ route('login') }}"
           class="px-6 py-3 bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-900 font-bold rounded-full border-2 border-gray-300 dark:border-gray-700 hover:bg-gray-800 dark:hover:bg-gray-200 transition">
            Log In
        </a>
        <a href="{{ route('register') }}"
           class="px-6 py-3 bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-gray-100 font-bold rounded-full border-2 border-gray-300 dark:border-gray-700 hover:bg-gray-300 dark:hover:bg-gray-700 transition">
            Register
        </a>
    </div>

    <!-- Theme Toggle -->
    <div>
        <button id="theme-toggle" type="button"
                class="flex items-center gap-2 px-5 py-3 rounded-xl border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition">
            <!-- Light icon -->
            <svg id="theme-toggle-light-icon" class="w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 3v1.5m0 15V21m9-9h-1.5M4.5 
                      12H3m15.364-7.364l-1.06 1.06M7.757 
                      16.243l-1.06 1.06M16.243 16.243l1.06 
                      1.06M7.757 7.757l1.06 1.06M12 
                      6.75a5.25 5.25 0 100 10.5 
                      5.25 5.25 0 000-10.5z"/>
            </svg>
            <!-- Dark icon -->
            <svg id="theme-toggle-dark-icon" class="w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M21.752 15.002A9.718 9.718 
                      0 0112 21.75a9.75 9.75 
                      0 01-9.75-9.75 9.75 9.75 
                      0 016.748-9.29 7.5 7.5 
                      0 0012.754 12.292z"/>
            </svg>
            <span>Toggle Theme</span>
        </button>
    </div>
</main>

<!-- Logo Animation + Shake -->
<style>
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        20% { transform: translateX(-2px); }
        40% { transform: translateX(2px); }
        60% { transform: translateX(-1px); }
        80% { transform: translateX(1px); }
    }
    .animate-shake {
        display: inline-block;
        animation: shake 0.6s ease-in-out infinite;
    }
</style>

<!-- Script for theme toggle -->
<script>
    const themeToggleBtn = document.getElementById('theme-toggle');
    const darkIcon = document.getElementById('theme-toggle-dark-icon');
    const lightIcon = document.getElementById('theme-toggle-light-icon');

    // On page load
    if (localStorage.getItem('color-theme') === 'dark' ||
        (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
        darkIcon.classList.add('hidden');
        lightIcon.classList.remove('hidden');
    } else {
        document.documentElement.classList.remove('dark');
        lightIcon.classList.add('hidden');
        darkIcon.classList.remove('hidden');
    }

    themeToggleBtn.addEventListener('click', function() {
        // Toggle icons
        darkIcon.classList.toggle('hidden');
        lightIcon.classList.toggle('hidden');

        // Toggle theme
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        }
    });
</script>
@endsection
