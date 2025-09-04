@extends('layouts.guest')

@section('content')
<main class="min-h-screen flex flex-col items-center justify-center space-y-8 px-4">

    <!-- Logo -->
    <div>
        <img src="{{ asset('images/logo.jpg') }}" alt="PostPit Logo" class="h-24 w-auto mx-auto">
    </div>

    <!-- Welcome Text -->
    <h1 class="text-4xl font-extrabold text-white text-center">
        Welcome back to <span class="text-yellow-400 animate-shake inline-block">PostPit</span>
    </h1>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" class="w-full max-w-sm space-y-4">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-white"/>
            <x-text-input id="email" class="block mt-1 w-full text-white bg-gray-900 border-yellow-400 focus:border-yellow-400 focus:ring-yellow-400"
                          type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-yellow-400"/>
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" class="text-white"/>
            <x-text-input id="password" class="block mt-1 w-full text-white bg-gray-900 border-yellow-400 focus:border-yellow-400 focus:ring-yellow-400"
                          type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-yellow-400"/>
        </div>

        <div class="flex items-center text-white">
            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-yellow-400 shadow-sm focus:ring-yellow-400" name="remember">
            <label for="remember_me" class="ml-2 text-sm">Remember me</label>
        </div>

        <div class="flex flex-col sm:flex-row sm:justify-between items-center mt-4 space-y-2 sm:space-y-0 sm:space-x-2">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-yellow-400 hover:text-white rounded-md" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="bg-yellow-400 text-black hover:bg-yellow-300 w-full sm:w-auto">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <p class="text-white text-center mt-4">
        Don't have an account?
        <a href="{{ route('register') }}" class="text-yellow-400 font-semibold hover:text-yellow-300">Register</a>
    </p>
</main>

<!-- Shake animation -->
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
@endsection
