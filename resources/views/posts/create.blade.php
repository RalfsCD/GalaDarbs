@extends('layouts.guest')

@section('content')
<main class="min-h-screen flex flex-col items-center justify-center p-6 bg-gray-50">

    <!-- Container -->
    <div class="w-full max-w-3xl bg-white/50 backdrop-blur-md border border-gray-200 rounded-3xl p-8 shadow-sm space-y-6">

        <!-- Logo -->
        <div class="flex justify-center">
            <img src="{{ asset('images/logo.jpg') }}" alt="PostPit Logo" class="h-32 w-auto">
        </div>

        <!-- Welcome Text -->
        <h1 class="text-3xl font-bold text-gray-900 text-center">
    Welcome to PostPit
</h1>

        <p class="text-gray-700 text-center max-w-xl mx-auto">
            Connect, share, and explore communities with PostPit. Join discussions, create posts, and discover new topics!
        </p>

        <!-- Buttons -->
        <div class="flex justify-center gap-6 mt-4">
            <a href="{{ route('login') }}" 
               class="px-6 py-3 bg-gray-900 text-white font-bold rounded-lg hover:bg-gray-800 transition border-2 border-gray-300">
                Log In
            </a>
            <a href="{{ route('register') }}" 
               class="px-6 py-3 bg-gray-200 text-gray-900 font-bold rounded-lg hover:bg-gray-300 transition border-2 border-gray-300">
                Register
            </a>
        </div>
    </div>
</main>
@endsection
