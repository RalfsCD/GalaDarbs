@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 space-y-6">

    {{-- Group Info --}}
    <div class="p-5 rounded-2xl 
                bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                backdrop-blur-md border border-gray-200 shadow-sm space-y-4">

        <div class="flex justify-between items-start">
            <!-- Group Name & Description -->
            <div class="space-y-1">
                <h1 class="text-4xl font-extrabold text-gray-900">{{ $group->name }}</h1>
                <p class="text-gray-600">{{ $group->description }}</p>
                <p class="text-gray-500 text-sm">Members: {{ $group->members->count() }}</p>
            </div>

          <!-- Delete Group button (creator/admin only) -->
@auth
    @if(auth()->id() === $group->creator_id || auth()->user()->isAdmin())
        <form action="{{ route('groups.destroy', $group) }}" method="POST"
              onsubmit="return confirm('Are you sure you want to delete this group?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="flex items-center justify-center w-10 h-10">
                <img src="{{ asset('icons/delete.svg') }}" alt="Delete" class="w-5 h-5">
            </button>
        </form>
    @endif
@endauth
        </div>

        {{-- Join/Leave Section --}}
        @auth
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-start gap-2 mt-2">
                @if($group->members->contains(auth()->id()))
                    <form action="{{ route('groups.leave', $group) }}" method="POST" class="flex-shrink-0">
                        @csrf
                        <button type="submit"
                                class="px-4 py-2 rounded-full border-2 border-gray-300 bg-green-200 text-green-800 font-bold hover:bg-green-300 transition">
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

    {{-- Create Post + Sort Card --}}
    <div class="p-5 rounded-2xl 
                bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                backdrop-blur-md border border-gray-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">

        <!-- Create Post Button -->
        <a href="{{ route('posts.create', $group) }}" 
           class="inline-flex items-center px-4 py-2 rounded-full border-2 border-gray-300 bg-gray-200 text-gray-900 font-bold hover:bg-gray-300 transition">
            <img src="{{ asset('icons/add.svg') }}" alt="Add" class="w-5 h-5 mr-2">
            Create Post
        </a>

        <!-- Sort Dropdown -->
        <form method="GET" id="sort-posts-form" action="{{ route('groups.show', $group) }}" class="flex-shrink-0">
            <select name="sort" id="sort-posts" onchange="this.form.submit()"
                    class="appearance-none px-4 py-2 rounded-full border-2 border-gray-300 bg-gray-200 text-gray-900 font-bold hover:bg-gray-300 transition focus:outline-none focus:ring-2 focus:ring-gray-300 cursor-pointer pr-8">
                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest First</option>
                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                <option value="most_liked" {{ request('sort') === 'most_liked' ? 'selected' : '' }}>Most Liked</option>
            </select>
        </form>
    </div>

    <style>
        #sort-posts::-ms-expand { display: none; }
        #sort-posts { -webkit-appearance: none; -moz-appearance: none; appearance: none; }
    </style>

    {{-- Posts Feed --}}
    <div id="posts-container" class="space-y-6 mt-4">
        @forelse($posts as $post)
            <a href="{{ route('posts.show', $post) }}" class="block group no-underline">
                <div class="post-item p-4 rounded-2xl 
                            bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                            backdrop-blur-md border border-gray-200 shadow-sm hover:shadow-md transition">

                    {{-- Post Header --}}
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            @if($post->user->profile_photo_path)
                                <img src="{{ asset('storage/' . $post->user->profile_photo_path) }}" 
                                     alt="{{ $post->user->name }}" 
                                     class="w-8 h-8 rounded-full object-cover shadow-sm">
                            @else
                                <div class="w-8 h-8 rounded-full bg-gray-400 flex items-center justify-center text-white font-bold text-xs shadow-sm">
                                    {{ strtoupper(substr($post->user->name, 0, 2)) }}
                                </div>
                            @endif
                            <p class="text-gray-900 font-bold">{{ $post->user->name }}</p>
                        </div>
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
                        @php $liked = auth()->check() && $post->likes->contains(auth()->id()); @endphp
                        <div class="flex items-center gap-1">
                            <img src="{{ $liked ? asset('icons/liked.svg') : asset('icons/like.svg') }}" class="w-5 h-5">
                            <span class="text-gray-700">{{ $post->likes_count ?? $post->likes->count() }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <img src="{{ asset('icons/comment.svg') }}" class="w-5 h-5">
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
