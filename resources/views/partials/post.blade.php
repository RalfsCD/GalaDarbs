@php
$isOwner = auth()->check() && auth()->id() === $post->user_id;
$liked = auth()->check() && $post->likes->contains(auth()->id());
@endphp

<div class="post-item p-4 rounded-2xl 
            bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
            dark:from-gray-800/30 dark:via-gray-800/50 dark:to-gray-800/30
            backdrop-blur-md border border-gray-200 dark:border-gray-700 
            shadow-sm hover:shadow-md transition"
    id="post-{{ $post->id }}">

    <div class="flex justify-between items-center">
        <p class="text-gray-900 dark:text-gray-100 font-bold">{{ $post->user->name }}</p>
        <span class="text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</span>
    </div>

    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mt-2">{{ $post->title }}</h3>

    @if(filled($post->content))
    <p class="text-gray-600 dark:text-gray-300 mt-1">{{ $post->content }}</p>
    @endif

    @if($post->media_path)
    <div class="mt-3">
        <img src="{{ asset('storage/' . $post->media_path) }}"
            alt="Post Image"
            class="rounded-lg max-w-full h-auto">
    </div>
    @endif

    {{-- Actions --}}
    <div class="flex items-center gap-6 mt-3">
        {{-- Like --}}
        <button type="button" class="like-btn flex items-center gap-1" data-post="{{ $post->id }}">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="like-icon w-6 h-6 transition-colors
                        {{ $liked ? 'fill-current text-red-600 dark:text-red-500' : 'text-gray-600 dark:text-gray-300' }}"
                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                 fill="{{ $liked ? 'currentColor' : 'none' }}">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 
                         0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 
                         3.75 3 5.765 3 8.25c0 7.22 9 12 9 
                         12s9-4.78 9-12Z"/>
            </svg>
            <span class="like-count text-gray-700 dark:text-gray-300 font-semibold">
                {{ $post->likes_count ?? $post->likes->count() }}
            </span>
        </button>

        {{-- Comments --}}
        <div class="flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-6 h-6 text-gray-600 dark:text-gray-300"
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
            <span class="comment-count text-gray-700 dark:text-gray-300 font-semibold">
                {{ $post->comments_count ?? $post->comments->count() }}
            </span>
        </div>

        {{-- Delete (if owner) --}}
        @if($isOwner)
        <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
              onsubmit="return confirm('Are you sure you want to delete this post?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="group">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-6 h-6 text-gray-500 group-hover:text-red-600 dark:text-gray-400 dark:group-hover:text-red-400 transition"
                     fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 
                             1.022.166m-1.022-.165L18.16 19.673a2.25 
                             2.25 0 0 1-2.244 2.077H8.084a2.25 
                             2.25 0 0 1-2.244-2.077L4.772 
                             5.79m14.456 0a48.108 48.108 0 
                             0 0-3.478-.397m-12 .562c.34-.059.68-.114 
                             1.022-.165m0 0a48.11 48.11 0 
                             1 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 
                             51.964 0 0 0-3.32 0c-1.18.037-2.09 
                             1.022-2.09 2.201v.916m7.5 0a48.667 
                             48.667 0 0 0-7.5 0"/>
                </svg>
            </button>
        </form>
        @endif
    </div>
</div>
