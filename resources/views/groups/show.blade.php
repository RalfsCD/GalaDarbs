@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 space-y-6">

    {{-- Group Info --}}
    <div class="bg-gray-900 border border-gray-700 p-5 rounded-2xl shadow-lg">
        <h1 class="text-3xl text-yellow-400 font-bold">{{ $group->name }}</h1>
        <p class="text-gray-300 mt-1">{{ $group->description }}</p>
    </div>

    {{-- Create Post button --}}
    <div class="mt-4">
        <a href="{{ route('posts.create', $group) }}" 
           class="bg-yellow-400 text-black px-4 py-2 rounded font-bold hover:bg-yellow-300">
           Create Post
        </a>
    </div>

    {{-- Sort Posts --}}
    <div class="flex justify-end mt-4 mb-2">
        <select id="sort-posts" class="bg-gray-900 text-yellow-400 p-2 rounded border border-gray-700">
            <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest First</option>
            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
            <option value="most_liked" {{ request('sort') === 'most_liked' ? 'selected' : '' }}>Most Liked</option>
        </select>
    </div>

    {{-- Posts Feed (Preview Only) --}}
    <div id="posts-container" class="space-y-6">
        @forelse($posts as $post)
            <a href="{{ route('posts.show', $post) }}" class="block group no-underline">
                <div class="post-item bg-gray-800 p-4 rounded-lg hover:bg-gray-700 transition">
                    <div class="flex justify-between items-center">
                        <p class="text-yellow-400 font-bold">{{ $post->user->name }}</p>
                        <span class="text-gray-400 text-sm">{{ $post->created_at->diffForHumans() }}</span>
                    </div>

                    <h3 class="text-xl font-semibold text-white mt-2">{{ $post->title }}</h3>

                    @if(filled($post->content))
                        <p class="text-gray-300 mt-1">{{ $post->content }}</p>
                    @endif

                    @if($post->media_path)
                        <div class="mt-3">
                            <img src="{{ asset('storage/' . $post->media_path) }}" 
                                 alt="Post Image" 
                                 class="rounded-lg max-w-full h-auto">
                        </div>
                    @endif

           {{-- Likes & Comments --}}
<div class="mt-3 flex items-center gap-4">
    {{-- Like --}}
    <div class="flex items-center gap-1">
        @php
            $liked = auth()->check() && $post->likes->contains(auth()->id());
        @endphp
        <img src="{{ $liked ? asset('icons/liked.svg') : asset('icons/like.svg') }}" 
             alt="Like" class="w-5 h-5">
        <span class="text-yellow-400">{{ $post->likes_count ?? $post->likes->count() }}</span>
    </div>

    {{-- Comments --}}
    <div class="flex items-center gap-1">
        <img src="{{ asset('icons/comment.svg') }}" alt="Comment" class="w-5 h-5">
        <span class="text-gray-400">{{ $post->comments_count ?? $post->comments->count() }}</span>
    </div>
</div>
                    </div>
                </div>
            </a>
        @empty
            <p class="text-gray-400">No posts yet in this group.</p>
        @endforelse
    </div>
</div>
@endsection
