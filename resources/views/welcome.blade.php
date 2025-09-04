@extends('layouts.guest')

@section('content')
<main class="min-h-screen flex flex-col items-center justify-center space-y-12 pt-6">

    <!-- Logo -->
    <div>
        <img src="{{ asset('images/logo.jpg') }}" alt="PostPit Logo" class="h-32 w-auto mx-auto">
    </div>

    <!-- Welcome Text -->
    <h1 class="text-5xl font-extrabold text-white">
        Welcome to <span class="text-yellow-400 animate-shake inline-block">PostPit</span>
    </h1>

    <!-- Buttons -->
    <div class="flex space-x-6">
        <a href="{{ route('login') }}" class="px-6 py-3 bg-yellow-400 text-black font-semibold rounded-lg hover:bg-yellow-300 transition">
            Log In
        </a>
        <a href="{{ route('register') }}" class="px-6 py-3 bg-transparent border-2 border-yellow-400 text-yellow-400 font-semibold rounded-lg hover:bg-yellow-400 hover:text-black transition">
            Register
        </a>
    </div>
</main>

<style>
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        20% { transform: translateX(-2px); }
        40% { transform: translateX(2px); }
        60% { transform: translateX(-1px); }
        80% { transform: translateX(1px); }
    }

    .animate-shake {
        animation: shake 0.6s ease-in-out infinite;
    }
</style>
@endsection
