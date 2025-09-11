@extends('layouts.guest')

@section('content')
<main class="min-h-screen flex flex-col items-center justify-center px-4 bg-gray-100">

    <!-- Glass panel container -->
    <div class="w-full max-w-md bg-white/50 backdrop-blur-md border border-gray-200 rounded-3xl p-8 shadow-sm space-y-6">

        <!-- Logo -->
        <div class="flex justify-center">
            <img src="{{ asset('images/logo.jpg') }}" alt="PostPit Logo" class="h-24 w-auto">
        </div>

        <!-- Welcome Text -->
        <h1 class="text-3xl font-extrabold text-gray-900 text-center">
            Join <span class="text-gray-700 animate-shake inline-block">PostPit</span>
        </h1>

        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" class="text-gray-900"/>
                <x-text-input id="name" class="block mt-1 w-full text-gray-900 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400"
                              type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-500"/>
            </div>

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-gray-900"/>
                <x-text-input id="email" class="block mt-1 w-full text-gray-900 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400"
                              type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500"/>
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="text-gray-900"/>
                <x-text-input id="password" class="block mt-1 w-full text-gray-900 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400"
                              type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500"/>
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-900"/>
                <x-text-input id="password_confirmation" class="block mt-1 w-full text-gray-900 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400"
                              type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-500"/>
            </div>

            <!-- Already registered + Register Button -->
            <div class="flex flex-col sm:flex-row sm:justify-between items-center mt-4 space-y-2 sm:space-y-0 sm:space-x-2">
                <a class="underline text-sm text-gray-700 hover:text-gray-900 rounded-md" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <button type="submit" 
                        class="w-full sm:w-auto px-4 py-3 bg-gray-900 text-white font-bold rounded-lg hover:bg-gray-800 transition">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>
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
