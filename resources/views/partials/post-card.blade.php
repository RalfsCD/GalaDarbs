<div class="post-card group relative select-none" data-post-id="{{ $post->id }}">
    <div class="p-6 rounded-2xl 
                bg-white dark:bg-gray-800 
                border border-gray-200 dark:border-gray-700
                shadow-md hover:shadow-lg transition-all duration-200">

        <!-- User Info -->
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center gap-3">
                @if($post->user->profile_photo_path)
                    <img src="{{ asset('storage/' . $post->user->profile_photo_path) }}"
                         alt="{{ $post->user->name }}"
                         class="w-10 h-10 rounded-full object-cover shadow-sm">
                @else
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-yellow-300 to-orange-400 flex items-center justify-center text-white font-bold shadow-sm">
                        {{ strtoupper(substr($post->user->name, 0, 2)) }}
                    </div>
                @endif
                <div>
                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $post->user->name }}</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">
                        in
                        <span class="bg-yellow-100 dark:bg-yellow-700/50 text-yellow-800 dark:text-yellow-100 px-2 py-0.5 rounded-full font-medium">
                            {{ $post->group->name }}
                        </span>
                    </p>
                </div>
            </div>
            <span class="text-gray-400 text-xs">{{ $post->created_at->diffForHumans() }}</span>
        </div>

        <!-- Title -->
        @if($post->title)
            <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                {{ $post->title }}
            </h3>
        @endif

        <!-- Content -->
        @if($post->content)
            <p class="text-gray-700 dark:text-gray-300 mb-4 leading-relaxed">
                {{ $post->content }}
            </p>
        @endif

        <!-- Media -->
        @if($post->media_path)
            <div class="media-wrapper relative rounded-xl overflow-hidden mb-4">
                <div class="aspect-video">
                    <img src="{{ asset('storage/' . $post->media_path) }}"
                         alt="Post Image"
                         class="w-full h-full object-cover cursor-pointer post-image"
                         data-src="{{ asset('storage/' . $post->media_path) }}">
                </div>
                <!-- Expand icon -->
                <button type="button"
                        class="expand-image absolute bottom-2 right-2 bg-black/50 hover:bg-black/70 text-white p-1.5 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 
                              0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 
                              0L9 15M20.25 3.75h-4.5m4.5 
                              0v4.5m0-4.5L15 9m5.25 
                              11.25h-4.5m4.5 0v-4.5m0 
                              4.5L15 15" />
                    </svg>
                </button>
            </div>
        @endif

        <!-- Actions -->
        <div class="flex items-center gap-6">
            @php $liked = auth()->check() && $post->likes->contains(auth()->id()); @endphp
            <!-- Like -->
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

            <!-- Comment trigger -->
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
        </div>
    </div>
</div>
