<div class="post-card p-4 sm:p-6 select-none rounded-3xl 
            bg-white dark:bg-gray-800 
            border border-gray-200 dark:border-gray-700 
            shadow-md hover:shadow-lg transition-all duration-200 mb-6"
     data-post-id="{{ $post->id }}">

    <div class="flex justify-between items-center mb-4">
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
                <p class="font-semibold text-gray-900 dark:text-gray-100 text-sm sm:text-base truncate">{{ $post->user->name }}</p>
                <p class="text-xs text-gray-600 dark:text-gray-400">
                    <a href="{{ route('groups.show', $post->group) }}"
                       class="inline-flex items-center gap-1.5 max-w-full
                              bg-yellow-50/80 dark:bg-yellow-500/15
                              text-yellow-900 dark:text-yellow-100
                              border border-yellow-300/60 dark:border-yellow-500/40
                              rounded-full px-2.5 py-0.5 font-semibold hover:bg-yellow-100/80
                              dark:hover:bg-yellow-500/25 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                             class="w-3.5 h-3.5 shrink-0">
                          <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                        <span class="truncate max-w-[160px] sm:max-w-[260px]" title="{{ $post->group->name }}">
                            {{ $post->group->name }}
                        </span>
                    </a>
                </p>
            </div>
        </div>
        <span class="text-gray-400 text-xs shrink-0 ml-2">{{ $post->created_at->diffForHumans() }}</span>
    </div>

    @if($post->title)
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 mb-3 break-words">{{ $post->title }}</h2>
    @endif

    @if($post->content)
        <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4 break-words">{{ $post->content }}</p>
    @endif

    @if($post->media_path)
        <div class="relative overflow-hidden rounded-xl mb-4">
            <img src="{{ asset('storage/' . $post->media_path) }}"
                 alt="Post Image"
                 class="post-image w-full max-h-[28rem] object-cover cursor-pointer transition-transform duration-300 hover:scale-[1.02]"
                 data-src="{{ asset('storage/' . $post->media_path) }}">
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

    <div class="flex items-center gap-4 sm:gap-6 mt-3 flex-wrap">
        @php
            $liked = auth()->check() && $post->likes->contains(auth()->id());
            $isOwner = auth()->check() && auth()->id() === $post->user_id;
            $isAdmin = auth()->check() && auth()->user()->role === 'admin';
        @endphp

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
            <span class="like-count text-gray-700 dark:text-gray-300 font-medium text-sm sm:text-base">
                {{ $post->likes_count ?? $post->likes->count() }}
            </span>
        </button>

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
            <span class="comment-count font-medium text-sm sm:text-base">
                {{ $post->comments_count ?? $post->comments->count() }}
            </span>
        </button>

        <button type="button" onclick="openReportModal({{ $post->id }})" class="group">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-6 h-6 text-gray-500 group-hover:text-red-600 dark:text-gray-400 dark:group-hover:text-red-400 transition">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5"/>
            </svg>
        </button>
    </div>
</div>

<div id="reportModal-{{ $post->id }}" class="hidden fixed inset-0 bg-black/40 dark:bg-black/70 z-50 items-center justify-center">
    <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-xl max-w-md w-full space-y-4 relative">
        <button onclick="closeReportModal({{ $post->id }})" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 dark:hover:text-gray-200 text-2xl">&times;</button>
        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Report Post</h2>
        <form method="POST" action="{{ route('reports.store', $post) }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Reason</label>
                <input type="text" name="reason" required maxlength="255"
                       class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 
                              bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 
                              placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 dark:focus:ring-red-600">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Details (optional)</label>
                <textarea name="details" rows="3" maxlength="1000"
                          class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 
                                 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 
                                 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-400 dark:focus:ring-red-600"></textarea>
            </div>
            <button type="submit"
                class="w-full py-2.5 rounded-lg bg-red-500 text-white font-bold hover:bg-red-600 transition">
                Submit Report
            </button>
        </form>
    </div>
</div>

<script>
function openReportModal(id) {
    document.getElementById(`reportModal-${id}`).classList.remove("hidden");
    document.getElementById(`reportModal-${id}`).classList.add("flex");
}
function closeReportModal(id) {
    document.getElementById(`reportModal-${id}`).classList.add("hidden");
    document.getElementById(`reportModal-${id}`).classList.remove("flex");
}
</script>
