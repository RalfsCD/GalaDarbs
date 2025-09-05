@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header + Add News button -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-white">Latest News</h1>
        <a href="{{ route('news.create') }}" 
           class="bg-yellow-400 text-black px-4 py-2 rounded font-bold hover:bg-yellow-300">
            + Add News
        </a>
    </div>

    <!-- News list -->
    @forelse ($news as $item)
        <div class="p-4 rounded-lg shadow">
            @if($item->image)
                <img src="{{ asset('storage/' . $item->image) }}" 
                     alt="{{ $item->title }}" 
                     class="w-full rounded border-4 border-yellow-400 mb-4 object-contain">
            @endif

            <h2 class="text-xl font-bold text-yellow-400">{{ $item->title }}</h2>
            <p class="text-gray-300 mt-2">{{ $item->content }}</p>
            <p class="text-sm text-gray-500 mt-2">Published {{ $item->created_at->diffForHumans() }}</p>
        </div>
    @empty
        <p class="text-gray-400">No news yet. Be the first to add one!</p>
    @endforelse
</div>
@endsection
