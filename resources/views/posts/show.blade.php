@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-3 sm:px-6 py-4 sm:py-6">

    {{-- Post Card --}}
    <div class="post-card p-4 sm:p-6 rounded-3xl
                bg-white dark:bg-gray-800
                border border-gray-200 dark:border-gray-700
                shadow-md hover:shadow-lg transition">

        {{-- Header --}}
        <div class="flex items-start justify-between gap-3 mb-4">
            <div class="flex items-center gap-3 min-w-0">
                @if($post->user->profile_photo_path)
                    <img src="{{ asset('storage/' . $post->user->profile_photo_path) }}"
                         alt="{{ $post->user->name }}"
                         class="w-10 h-10 rounded-full object-cover shadow-sm shrink-0">
                @else
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center text-white font-bold shrink-0">
                        {{ strtoupper(substr($post->user->name, 0, 2)) }}
                    </div>
                @endif
                <div class="min-w-0">
                    <p class="font-semibold text-gray-900 dark:text-gray-100 truncate">
                        {{ $post->user->name }}
                    </p>

                    {{-- prettier “in Group” pill (matches new style) --}}
                    <div class="mt-0.5 flex items-center gap-2 text-[12px] text-gray-500 dark:text-gray-400">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full
                                     bg-yellow-100/80 dark:bg-yellow-500/20
                                     text-yellow-800 dark:text-yellow-100
                                     border border-yellow-300/60 dark:border-yellow-500/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0z"/>
                            </svg>
                            <span class="font-semibold truncate max-w-[160px] sm:max-w-none">
                                {{ $post->group->name }}
                            </span>
                        </span>
                        <span class="hidden xs:inline text-gray-400">•</span>
                        <span class="hidden xs:inline text-gray-500 dark:text-gray-400">{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <span class="xs:hidden text-gray-400 text-xs shrink-0">{{ $post->created_at->diffForHumans() }}</span>
        </div>

        {{-- Title --}}
        @if($post->title)
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 mb-3 break-words">
                {{ $post->title }}
            </h1>
        @endif

        {{-- Content --}}
        @if($post->content)
            <p class="text-[15px] sm:text-base text-gray-700 dark:text-gray-300 leading-relaxed mb-4 break-words">
                {{ $post->content }}
            </p>
        @endif

        {{-- Media --}}
        @if($post->media_path)
            <div class="relative overflow-hidden rounded-xl mb-4">
                <img src="{{ asset('storage/' . $post->media_path) }}"
                     alt="Post Image"
                     class="post-image w-full max-h-[28rem] object-cover cursor-pointer transition-transform duration-300 hover:scale-[1.02]"
                     data-src="{{ asset('storage/' . $post->media_path) }}">
                {{-- Optional: expand button (works with your lightbox in post-scripts) --}}
                <button type="button"
                        class="expand-image absolute top-2 right-2 z-10 inline-flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10
                               rounded-full bg-black/50 hover:bg-black/60 text-white shadow-md backdrop-blur-sm
                               focus:outline-none focus:ring-2 focus:ring-yellow-300"
                        aria-label="Expand image">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.8" class="w-5 h-5 sm:w-6 sm:h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 9V4.5H8.25M20.25 15v4.5H15.75M8.25 4.5 4.5 8.25M15.75 19.5l3.75-3.75M14.25 9h3.75V5.25M9.75 15H6v3.75"/>
                    </svg>
                </button>
            </div>
        @endif

        {{-- Actions --}}
        <div class="flex items-center gap-4 sm:gap-6 mt-3 flex-wrap">
            @php
                $liked = auth()->check() && $post->likes->contains(auth()->id());
                $isOwner = auth()->check() && auth()->id() === $post->user_id;
                $isAdmin = auth()->check() && auth()->user()->role === 'admin';
            @endphp

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

            {{-- Comment trigger (works with dashboard drawer JS) --}}
            <button type="button" class="comment-trigger flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-blue-500 transition-colors" data-post="{{ $post->id }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                     fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"/>
                </svg>
                <span class="comment-count font-medium">
                    {{ $post->comments_count ?? $post->comments->count() }}
                </span>
            </button>

            {{-- Delete (owner/admin) --}}
            @if($isOwner || $isAdmin)
                <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this post?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                        </svg>
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

{{-- ===== Comment Drawer (EXACT same structure as dashboard) ===== --}}
<div id="commentDrawer" class="fixed inset-0 hidden bg-black/40 dark:bg-black/70 z-50 justify-end">
    <div class="bg-white dark:bg-gray-900 w-full sm:w-[480px] h-full shadow-2xl flex flex-col">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h2 class="text-lg font-bold">Comments</h2>
            <button id="closeComments" class="text-gray-500 hover:text-gray-800 dark:hover:text-gray-200">&times;</button>
        </div>
        <div id="commentsList" class="flex-1 overflow-y-auto p-4 space-y-3"></div>
        <form id="commentForm" class="p-4 border-t border-gray-200 dark:border-gray-700 flex gap-2">
            @csrf
            <input type="hidden" name="post_id" id="commentPostId" value="{{ $post->id }}">
            <input name="content" placeholder="Write a comment..."
                   class="flex-1 rounded-full p-2 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring focus:ring-yellow-300 dark:focus:ring-yellow-600">
            <button class="px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-white rounded-full">Send</button>
        </form>
    </div>
</div>

{{-- Image Lightbox (compatible with post-scripts) --}}
<div id="imageModal" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50">
    <span id="closeImageModal" class="absolute top-6 right-8 text-white text-4xl cursor-pointer">&times;</span>
    <img id="modalImage" src="" class="max-h-[90%] max-w-[90%] rounded-xl shadow-2xl">
</div>
@endsection

@section('scripts')
@include('partials.post-scripts')
@endsection
