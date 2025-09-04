@extends('layouts.app')

@section('content')
<main class="bg-black text-white min-h-screen p-6">
    <h1 class="text-3xl font-extrabold">
        Welcome to 
        <span class="inline-block animate-shake text-yellow-400">PostPit</span>
    </h1>
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
        display: inline-block;
        animation: shake 0.6s ease-in-out infinite;
    }
</style>
@endsection
