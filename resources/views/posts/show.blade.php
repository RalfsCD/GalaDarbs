@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">

    {{-- Post Card --}}
    <div class="post-card p-6 rounded-3xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-md">
        
        {{-- Header --}}
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center gap-3">
                @if($post->user->profile_photo_path)
                    <img src="{{ asset('storage/' . $post->user->profile_photo_path) }}"
                         alt="{{ $post->user->name }}"
                         class="w-10 h-10 rounded-full object-cover shadow-sm">
                @else
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr($post->user->name, 0, 2)) }}
                    </div>
                @endif
                <div>
                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $post->user->name }}</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">
                        in <span class="bg-yellow-100 dark:bg-yellow-700/50 text-yellow-800 dark:text-yellow-100 px-2 py-0.5 rounded-full font-medium">
                            {{ $post->group->name }}
                        </span>
                    </p>
                </div>
            </div>
            <span class="text-gray-400 text-xs">{{ $post->created_at->diffForHumans() }}</span>
        </div>

        {{-- Title --}}
        @if($post->title)
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-3">{{ $post->title }}</h2>
        @endif

        {{-- Content --}}
        @if($post->content)
            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">{{ $post->content }}</p>
        @endif

        {{-- Media --}}
        @if($post->media_path)
            <div class="overflow-hidden rounded-xl mb-4">
                <img src="{{ asset('storage/' . $post->media_path) }}"
                     alt="Post Image"
                     class="w-full max-h-[28rem] object-cover cursor-pointer transition-transform duration-300 hover:scale-[1.02] post-image"
                     data-src="{{ asset('storage/' . $post->media_path) }}">
            </div>
        @endif

        {{-- Actions --}}
        <div class="flex items-center gap-6 mt-3">
            @php $liked = auth()->check() && $post->likes->contains(auth()->id()); @endphp

            {{-- Like --}}
            <button type="button" class="like-btn flex items-center gap-2 group" data-post="{{ $post->id }}">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="like-icon w-6 h-6 transition-colors
                           {{ $liked ? 'fill-current text-red-600 dark:text-red-500' : 'text-gray-500 dark:text-gray-400 group-hover:text-pink-500' }}"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    fill="{{ $liked ? 'currentColor' : 'none' }}">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 
                             0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 
                             3.75 3 5.765 3 8.25c0 7.22 9 12 9 
                             12s9-4.78 9-12Z"/>
                </svg>
                <span class="like-count text-gray-700 dark:text-gray-300 font-medium">
                    {{ $post->likes_count ?? $post->likes->count() }}
                </span>
            </button>

            {{-- Comment trigger --}}
            <button type="button" class="comment-trigger flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-blue-500 transition-colors" data-post="{{ $post->id }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                     fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.625 9.75a.375.375 0 1 1-.75 0 
                        .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 
                        0a.375.375 0 1 1-.75 0 .375.375 
                        0 0 1 .75 0Zm0 0H12m4.125 
                        0a.375.375 0 1 1-.75 0 .375.375 
                        0 0 1 .75 0Zm0 0h-.375m-13.5 
                        3.01c0 1.6 1.123 2.994 2.707 
                        3.227 1.087.16 2.185.283 
                        3.293.369V21l4.184-4.183a1.14 
                        1.14 0 0 1 .778-.332 
                        48.294 48.294 0 0 0 
                        5.83-.498c1.585-.233 
                        2.708-1.626 
                        2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 
                        48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 
                        3.746 2.25 5.14 2.25 
                        6.741v6.018Z"/>
                </svg>
                <span class="comment-count font-medium">
                    {{ $post->comments_count ?? $post->comments->count() }}
                </span>
            </button>

            {{-- Delete (if owner or admin) --}}
            @auth
            @if(auth()->id() === $post->user_id || auth()->user()->role === 'admin')
            <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this post?');">
                @csrf
                @method('DELETE')
                 <button type="submit"
                    class="flex items-center justify-center w-10 h-10 rounded-full text-gray-600 dark:text-gray-400 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
            </button>
                </button>
            </form>
            @endif
            @endauth
        </div>
    </div>
</div>

{{-- Reuse global drawers --}}
<div id="commentDrawer" class="hidden fixed inset-0 bg-black/50 z-50 items-end justify-center">
    <div class="bg-white dark:bg-gray-900 w-full md:max-w-xl rounded-t-2xl md:rounded-2xl p-6 flex flex-col space-y-4">
        <button id="closeComments" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800">&times;</button>
        <h2 class="text-lg font-bold">Comments</h2>
        <div id="commentsList" class="flex-1 space-y-3 overflow-y-auto max-h-80"></div>
        <form id="commentForm" class="flex items-center gap-3">
            @csrf
            <input type="hidden" id="commentPostId" name="post_id" value="{{ $post->id }}">
            <input name="content" required class="flex-1 p-2 rounded-full border bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
            <button class="px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-white rounded-full">Send</button>
        </form>
    </div>
</div>

<div id="imageModal" class="hidden fixed inset-0 bg-black/80 z-50 items-center justify-center">
    <span id="closeImageModal" class="absolute top-6 right-8 text-white text-3xl cursor-pointer">&times;</span>
    <img id="modalImage" class="max-h-[90%] max-w-[90%] rounded-lg shadow-lg">
</div>
@endsection

@section('scripts')
@include('partials.post-scripts')
@endsection
