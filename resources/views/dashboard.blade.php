@extends('layouts.app')

@section('content')
<div class="bg-black text-white min-h-screen p-6 space-y-8">
    <h1 class="text-3xl font-extrabold">
        Welcome to <span class="inline-block animate-shake text-yellow-400">PostPit</span>
    </h1>

    <div class="space-y-6 max-w-3xl mx-auto">
        @forelse($posts as $post)
            <a href="{{ route('posts.show', $post) }}">
                <div class="p-4 bg-gray-800 rounded-lg shadow hover:bg-gray-700 transition">
                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <p class="text-yellow-400 font-bold">{{ $post->user->name }}</p>
                            <p class="text-gray-400 text-sm">in {{ $post->group->name }}</p>
                        </div>
                        <span class="text-gray-500 text-xs">{{ $post->created_at->diffForHumans() }}</span>
                    </div>

                    @if($post->title)
                        <h2 class="text-xl font-bold text-white mb-2">{{ $post->title }}</h2>
                    @endif

                    <p class="text-gray-200 mb-2">{{ $post->content }}</p>

                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="rounded-lg mb-2">
                    @endif

                    <div class="flex justify-between items-center text-sm text-gray-400 mt-3">
                        <span>{{ $post->likes->count() }} Likes</span>
                        <span>{{ $post->comments->count() }} Comments</span>
                    </div>
                </div>
            </a>
        @empty
            <p class="text-gray-400">No posts yet. Join some groups to see activity here!</p>
        @endforelse

        {{ $posts->links() }}
    </div>
</div>

<style>
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    20% { transform: translateX(-2px); }
    40% { transform: translateX(2px); }
    60% { transform: translateX(-1px); }
    80% { transform: translateX(1px); }
}
.animate-shake { display:inline-block; animation:shake 0.6s ease-in-out infinite; }
</style>
@endsection
