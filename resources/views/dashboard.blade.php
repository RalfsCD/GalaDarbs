@extends('layouts.app')

@section('content')
<div class="flex h-screen gap-6 bg-gray-100">

    <!-- Feed Section -->
    <div class="flex-1 overflow-y-auto px-6 py-6 space-y-6 scrollbar-hide">
        <h2 class="text-2xl font-extrabold text-gray-900">Newest Posts</h2>

        @forelse($posts as $post)
            <a href="{{ route('posts.show', $post) }}" class="block no-underline">
                <div class="p-4 rounded-2xl bg-white/30 backdrop-blur-md border border-gray-200 shadow-sm hover:shadow-md transition overflow-hidden">
                    
                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <p class="font-bold text-gray-900">{{ $post->user->name }}</p>
                            <p class="text-gray-500 text-sm">in {{ $post->group->name }}</p>
                        </div>
                        <span class="text-gray-400 text-xs">{{ $post->created_at->diffForHumans() }}</span>
                    </div>

                    @if($post->title)
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $post->title }}</h3>
                    @endif

                    <p class="text-gray-700 mb-2">{{ $post->content }}</p>

                    @if($post->media_path)
                        <img src="{{ asset('storage/' . $post->media_path) }}" 
                             alt="Post Image" 
                             class="rounded-lg mb-2 max-w-full h-auto shadow-sm">
                    @endif

                    {{-- Likes & Comments --}}
                    <div class="flex items-center gap-4 mt-3">
                        @php
                            $liked = auth()->check() && $post->likes->contains(auth()->id());
                        @endphp
                        <div class="flex items-center gap-1">
                            <img src="{{ $liked ? asset('icons/liked.svg') : asset('icons/like.svg') }}" alt="Like" class="w-5 h-5">
                            <span class="text-gray-900 font-medium">{{ $post->likes_count ?? $post->likes->count() }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <img src="{{ asset('icons/comment.svg') }}" alt="Comment" class="w-5 h-5">
                            <span class="text-gray-900 font-medium">{{ $post->comments_count ?? $post->comments->count() }}</span>
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <p class="text-gray-500">No posts yet. Join some groups to see activity here!</p>
        @endforelse

        {{ $posts->links() }}
    </div>

    <!-- Groups Section -->
    <div class="w-80 overflow-y-auto px-6 py-6 space-y-6 border-l border-gray-300 scrollbar-hide">
        <h2 class="text-2xl font-extrabold text-gray-900">Your Groups</h2>

        @forelse($joinedGroups as $group)
            <a href="{{ route('groups.show', $group) }}" class="block no-underline">
                <div class="p-4 rounded-2xl bg-white/30 backdrop-blur-md border border-gray-200 shadow-sm hover:shadow-md transition">
                    <h3 class="text-xl font-bold text-gray-900">{{ $group->name }}</h3>
                    <p class="text-gray-600 mt-1">{{ $group->description ?? 'No description.' }}</p>
                    <p class="text-sm text-gray-700 mt-2">
                        Topics: {{ $group->topics->pluck('name')->join(', ') }}
                    </p>

                    @if($group->members->contains(auth()->id()))
                        <span class="mt-3 inline-block px-3 py-1 rounded-full bg-green-200 text-green-800 font-semibold text-sm">
                            Joined
                        </span>
                    @endif
                </div>
            </a>
        @empty
            <p class="text-gray-500">You haven’t joined any groups yet.</p>
        @endforelse
    </div>
</div>

<style>
/* Hide scrollbars for smooth look */
.scrollbar-hide::-webkit-scrollbar { display: none; }
.scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

/* Shake animation for logo/text */
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
