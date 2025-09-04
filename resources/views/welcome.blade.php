@extends('layouts.app')

@section('content')
<main class="bg-black min-h-screen flex flex-col items-center justify-center space-y-12 pt-6">

    <!-- Logo -->
    <div>
        <img src="{{ asset('images/logo.jpg') }}" alt="PostPit Logo" class="h-32 w-auto mx-auto">
    </div>

    <!-- Welcome Text -->
    <h1 class="text-5xl font-extrabold text-white">
        Welcome to <span class="text-yellow-400">PostPit</span>
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
@endsection
