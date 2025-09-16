@extends('layouts.guest')

@section('content')
<main class="min-h-screen flex flex-col items-center justify-center space-y-12 pt-6 bg-gray-50">

    <!-- Logo Container -->
    <img src="{{ asset('images/logo.jpg') }}" alt="PostPit Logo" class="h-32 w-auto mx-auto">

    <!-- Welcome Text -->
    <h1 class="text-5xl font-extrabold text-gray-900 text-center">
        Welcome to <span class="text-gray-400 inline-block">PostPit</span>
    </h1>

    <p class="text-gray-700 text-center max-w-xl">
        Connect, share, and explore communities with PostPit. Join discussions, create posts, and discover new topics!
    </p>

    <!-- Buttons -->
    <div class="flex space-x-6">
        <a href="{{ route('login') }}" 
           class="px-6 py-3 bg-gray-900 text-white font-bold rounded-full border-2 border-gray-300 hover:bg-gray-800 transition">
            Log In
        </a>
        <a href="{{ route('register') }}" 
           class="px-6 py-3 bg-gray-200 text-gray-900 font-bold rounded-full border-2 border-gray-300 hover:bg-gray-300 transition">
            Register
        </a>
    </div>
</main>

<style>
    /* Shake animation */
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

    /* Removed yellow glow */
    img {
        border-radius: 1rem;
    }
</style>
@endsection
