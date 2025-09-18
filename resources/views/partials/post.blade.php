

<div class="post-item p-4 rounded-2xl 
            bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
            backdrop-blur-md border border-gray-200 shadow-sm hover:shadow-md transition"
     id="post-{{ $post->id }}">

    <div class="flex justify-between items-center">
        <p class="text-gray-900 font-bold">{{ $post->user->name }}</p>
        <span class="text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</span>
    </div>

    <h3 class="text-xl font-semibold text-gray-900 mt-2">{{ $post->title }}</h3>

    @if(filled($post->content))
        <p class="text-gray-600 mt-1">{{ $post->content }}</p>
    @endif

    @if($post->media_path)
        <div class="mt-3">
            <img src="{{ asset('storage/' . $post->media_path) }}" 
                 alt="Post Image" 
                 class="rounded-lg max-w-full h-auto">
        </div>
    @endif

    {{-- Likes / Comments / Delete --}}
    <div class="flex items-center gap-6 mt-3">
        {{-- Like --}}
        <button type="button" class="like-btn flex items-center gap-1" data-post="{{ $post->id }}">
            <img src="{{ $liked ? asset('icons/liked.svg') : asset('icons/like.svg') }}" 
                 alt="Like" class="w-6 h-6 inline-block">
            <span class="like-count text-gray-700 font-semibold">
                {{ $post->likes_count ?? $post->likes->count() }}
            </span>
        </button>

        {{-- Comments --}}
        <div class="flex items-center gap-1">
            <img src="{{ asset('icons/comment.svg') }}" alt="Comments" class="w-6 h-6">
            <span class="comment-count text-gray-700 font-semibold">
                {{ $post->comments_count ?? $post->comments->count() }}
            </span>
        </div>


        
        @if($isOwner)
            <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this post?');">
                @csrf
                @method('DELETE')
                <input type="hidden" name="group_id" value="{{ $post->group_id }}">
                <button type="submit">
                    <img src="{{ asset('icons/delete.svg') }}" alt="Delete" class="w-6 h-6">
                </button>
            </form>
        @endif
    </div>
</div>
