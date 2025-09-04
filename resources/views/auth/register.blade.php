@extends('layouts.guest')

@section('content')
<main class="min-h-screen flex flex-col items-center justify-center space-y-8 px-4">

    <!-- Logo -->
    <div>
        <img src="{{ asset('images/logo.jpg') }}" alt="PostPit Logo" class="h-24 w-auto mx-auto">
    </div>

    <!-- Welcome Text -->
    <h1 class="text-4xl font-extrabold text-white text-center">
        Join <span class="text-yellow-400 animate-shake inline-block">PostPit</span>
    </h1>

    <!-- Register Form -->
    <form method="POST" action="{{ route('register') }}" class="w-full max-w-sm space-y-4">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')" class="text-white"/>
            <x-text-input id="name" class="block mt-1 w-full text-white bg-gray-900 border-yellow-400 focus:border-yellow-400 focus:ring-yellow-400"
                          type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-yellow-400"/>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-white"/>
            <x-text-input id="email" class="block mt-1 w-full text-white bg-gray-900 border-yellow-400 focus:border-yellow-400 focus:ring-yellow-400"
                          type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-yellow-400"/>
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" class="text-white"/>
            <x-text-input id="password" class="block mt-1 w-full text-white bg-gray-900 border-yellow-400 focus:border-yellow-400 focus:ring-yellow-400"
                          type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-yellow-400"/>
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-white"/>
            <x-text-input id="password_confirmation" class="block mt-1 w-full text-white bg-gray-900 border-yellow-400 focus:border-yellow-400 focus:ring-yellow-400"
                          type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-yellow-400"/>
        </div>

        <div class="flex flex-col sm:flex-row sm:justify-between items-center mt-4 space-y-2 sm:space-y-0 sm:space-x-2">
            <a class="underline text-sm text-yellow-400 hover:text-white rounded-md" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="bg-yellow-400 text-black hover:bg-yellow-300 w-full sm:w-auto">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
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
