<div class="post-card p-6 rounded-3xl 
            bg-white dark:bg-gray-800 
            border border-gray-200 dark:border-gray-700 
            shadow-md hover:shadow-lg transition-all duration-200 mb-6"
     data-post-id="{{ $post->id }}">

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

        {{-- Report (if not owner/admin) --}}
        @if(auth()->check() && !$isOwner && !$isAdmin)
        <button type="button" onclick="openReportModal({{ $post->id }})" class="group">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-6 h-6 text-gray-500 group-hover:text-red-600 dark:text-gray-400 dark:group-hover:text-red-400 transition">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5"/>
            </svg>
        </button>
        @endif
    </div>
</div>

<!-- Report Modal -->
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
