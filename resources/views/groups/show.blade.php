@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 space-y-6">

{{-- Group Info --}}
<div class="p-5 rounded-2xl 
            bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
            backdrop-blur-md border border-gray-200 shadow-sm space-y-4">

    <!-- Group Name & Description -->
    <div class="space-y-1">
        <h1 class="text-3xl font-bold text-gray-900">{{ $group->name }}</h1>
        <p class="text-gray-600">{{ $group->description }}</p>
        <p class="text-gray-500 text-sm">Members: {{ $group->members->count() }}</p>
    </div>

    <!-- Join/Leave Section -->
    @auth
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mt-4">
            @if($group->members->contains(auth()->id()))
                <form action="{{ route('groups.leave', $group) }}" method="POST" class="flex-shrink-0">
                    @csrf
                    <button type="submit"
                            class="px-4 py-2 rounded-full border-2 border-gray-300 bg-white text-gray-700 font-bold hover:bg-gray-100 transition">
                        Joined
                    </button>
                </form>
                <p class="text-gray-500 text-sm sm:ml-4">
                    You are part of this group and will see its latest posts in your home feed.
                </p>
            @else
                <form action="{{ route('groups.join', $group) }}" method="POST" class="flex-shrink-0">
                    @csrf
                    <button type="submit"
                            class="px-4 py-2 rounded-full border-2 border-gray-300 bg-gray-200 text-gray-900 font-bold hover:bg-gray-300 transition">
                        Join
                    </button>
                </form>
                <p class="text-gray-500 text-sm sm:ml-4">
                    Join this group to get the newest posts in your home feed.
                </p>
            @endif
        </div>
    @endauth
</div>

    {{-- Create Post button --}}
    <div class="mt-4">
        <a href="{{ route('posts.create', $group) }}" 
           class="inline-flex items-center px-4 py-2 rounded-full border-2 border-gray-300 bg-gray-200 text-gray-900 font-bold hover:bg-gray-300 transition">
            <img src="{{ asset('icons/add.svg') }}" alt="Add" class="w-5 h-5 mr-2">
            Create Post
        </a>
    </div>

    {{-- Sort Posts --}}
   <div class="flex justify-end mt-4 mb-2">
    <form method="GET" id="sort-posts-form" action="{{ route('groups.show', $group) }}">
        <select name="sort" id="sort-posts" 
                onchange="this.form.submit()"
                class="appearance-none px-4 py-2 rounded-full border-2 border-gray-300 bg-gray-200 text-gray-900 font-bold hover:bg-gray-300 transition focus:outline-none focus:ring-2 focus:ring-gray-300 cursor-pointer pr-8 relative">
            <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest First</option>
            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
            <option value="most_liked" {{ request('sort') === 'most_liked' ? 'selected' : '' }}>Most Liked</option>
        </select>
    </form>
</div>

<style>
    /* Remove default arrow in select for most browsers */
    #sort-posts::-ms-expand { display: none; } /* IE10+ */
    #sort-posts {
        -webkit-appearance: none; /* Safari/Chrome */
        -moz-appearance: none;    /* Firefox */
        appearance: none;         /* Standard */
    }
</style>


    {{-- Posts Feed --}}
    <div id="posts-container" class="space-y-6">
        @forelse($posts as $post)
            <a href="{{ route('posts.show', $post) }}" class="block group no-underline">
                <div class="post-item p-4 rounded-2xl 
                            bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                            backdrop-blur-md border border-gray-200 shadow-sm hover:shadow-md transition">

                    {{-- Post Header --}}
                    <div class="flex justify-between items-center">
                        <p class="text-gray-900 font-bold">{{ $post->user->name }}</p>
                        <span class="text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</span>
                    </div>

                    {{-- Title & Content --}}
                    <h3 class="text-xl font-semibold text-gray-900 mt-2">{{ $post->title }}</h3>

                    @if(filled($post->content))
                        <p class="text-gray-600 mt-1">{{ $post->content }}</p>
                    @endif

                    {{-- Media --}}
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
                            <span class="text-gray-700">{{ $post->likes_count ?? $post->likes->count() }}</span>
                        </div>

                        {{-- Comments --}}
                        <div class="flex items-center gap-1">
                            <img src="{{ asset('icons/comment.svg') }}" alt="Comment" class="w-5 h-5">
                            <span class="text-gray-700">{{ $post->comments_count ?? $post->comments->count() }}</span>
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <p class="text-gray-500">No posts yet in this group.</p>
        @endforelse
    </div>
</div>
@endsection
