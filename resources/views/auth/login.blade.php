@extends('layouts.guest')

@section('content')
<main class="min-h-screen flex flex-col items-center justify-center space-y-8 px-4 bg-gray-100">

    <!-- Glass panel container -->
    <div class="w-full max-w-md bg-white/50 backdrop-blur-md border border-gray-200 rounded-3xl p-8 shadow-sm space-y-6">

        <!-- Logo -->
        <div class="flex justify-center">
            <img src="{{ asset('images/logo.jpg') }}" alt="PostPit Logo" class="h-24 w-auto">
        </div>

        <!-- Welcome Text -->
        <h1 class="text-3xl font-extrabold text-gray-900 text-center">
            Welcome back to <span class="text-gray-700 animate-shake inline-block">PostPit</span>
        </h1>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-gray-900"/>
                <x-text-input id="email" class="block mt-1 w-full text-gray-900 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400"
                              type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500"/>
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="text-gray-900"/>
                <x-text-input id="password" class="block mt-1 w-full text-gray-900 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400"
                              type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500"/>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center text-gray-900">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-gray-900 shadow-sm focus:ring-gray-400" name="remember">
                <label for="remember_me" class="ml-2 text-sm">Remember me</label>
            </div>

            <!-- Forgot password + Login -->
            <div class="flex flex-col sm:flex-row sm:justify-between items-center mt-4 space-y-2 sm:space-y-0 sm:space-x-2">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-700 hover:text-gray-900 rounded-md" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <button type="submit" 
                        class="w-full sm:w-auto px-4 py-3 bg-gray-900 text-white font-bold rounded-lg hover:bg-gray-800 transition">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>

        <!-- Register link -->
        <p class="text-gray-700 text-center mt-4">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-gray-900 font-semibold hover:text-gray-800">Register</a>
        </p>
    </div>
</main>

<!-- Loading Screen -->
<div id="loading-overlay" class="fixed inset-0 bg-gray-100 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-opacity duration-700">
    <img src="{{ asset('images/logo.jpg') }}" alt="Loading Logo" class="h-32 w-auto animate-spin-slow">
</div>

<!-- Animations -->
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
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-slow {
        animation: spin-slow 1.5s linear infinite;
    }
</style>

<!-- Script -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const forms = document.querySelectorAll("form");
        const overlay = document.getElementById("loading-overlay");

        forms.forEach(form => {
            form.addEventListener("submit", function() {
                overlay.classList.remove("pointer-events-none");
                overlay.classList.add("opacity-100");
            });
        });
    });
</script>
@endsection
