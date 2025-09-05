@extends('layouts.app')

@section('content')
<main class="bg-black min-h-screen pt-6 pl-6">
    <div class="max-w-4xl space-y-10">

        <!-- Header + Add News button -->
        <div class="flex justify-between items-center">
            <h1 class="text-4xl font-extrabold text-white">
                Latest 
                <span class="inline-block animate-shake text-yellow-400">News</span>
            </h1>
            <a href="{{ route('news.create') }}" 
               class="bg-yellow-400 text-black px-4 py-2 rounded font-bold hover:bg-yellow-300">
                + Add News
            </a>
        </div>

        <!-- News list -->
        @forelse ($news as $item)
            <div class="space-y-4">
                @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" 
                         alt="{{ $item->title }}" 
                         class="w-full border-4 border-yellow-400 rounded object-contain">
                @endif

                <h2 class="text-2xl font-bold text-yellow-400">{{ $item->title }}</h2>
                <p class="text-white text-lg leading-relaxed">{{ $item->content }}</p>
                <p class="text-sm text-gray-400">Published {{ $item->created_at->diffForHumans() }}</p>
            </div>
        @empty
            <p class="text-gray-400">No news yet. Be the first to add one!</p>
        @endforelse

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
        display: inline-block;
        animation: shake 0.6s ease-in-out infinite;
    }
</style>
@endsection
