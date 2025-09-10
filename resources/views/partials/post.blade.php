@php
    use Illuminate\Support\Facades\Storage;
    $isOwner  = auth()->check() && (int) auth()->id() === (int) $post->user_id;
@endphp

<div class="post-item p-5 bg-gray-900 rounded-2xl shadow-lg border border-gray-700 mb-6" id="post-{{ $post->id }}">
    <div class="flex justify-between items-center mb-3">
        <div>
            <p class="text-yellow-400 font-bold">{{ $post->user->name ?? 'Unknown' }}</p>
            <p class="text-gray-400 text-sm">in {{ $post->group->name ?? '' }}</p>
        </div>
        <span class="text-gray-500 text-xs">{{ $post->created_at->diffForHumans() }}</span>
    </div>

    @if($post->title)
        <h3 class="text-xl font-semibold text-white mb-2">{{ $post->title }}</h3>
    @endif

    @if(filled($post->content))
        <p class="text-gray-300 mb-3">{{ $post->content }}</p>
    @endif

    @if($post->media_path)
        <div class="mt-2">
            <img src="{{ Storage::url($post->media_path) }}" 
                 alt="Post image" 
                 class="rounded-lg max-w-full h-auto shadow-md"
                 onerror="this.style.display='none'">
        </div>
    @endif

    <div class="mt-4 flex items-center gap-6">
        <button type="button"
                class="like-btn text-yellow-400 hover:text-yellow-300 {{ auth()->check() && $post->likes->contains(auth()->id()) ? 'liked' : '' }}"
                data-post="{{ $post->id }}">
            ❤️ <span class="like-count">{{ $post->likes_count ?? $post->likes->count() }}</span>
        </button>

        <span class="text-gray-400 comment-count">
            {{ $post->comments_count ?? $post->comments->count() }}
            {{ ($post->comments_count ?? $post->comments->count()) === 1 ? 'comment' : 'comments' }}
        </span>
    </div>

    <div class="comments-container mt-4 space-y-2">
        @foreach($post->comments as $comment)
            @include('partials.comment', ['comment' => $comment])
        @endforeach
    </div>

    <form class="comment-form mt-3" data-post="{{ $post->id }}">
        @csrf
        <input name="content" required
               class="w-full p-2 rounded bg-black text-yellow-400 border-2 border-yellow-400"
               placeholder="Write a comment...">
    </form>

    @if($isOwner)
    <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
          onsubmit="return confirm('Delete this post?');"
          class="mt-3">
        @csrf
        @method('DELETE')
        <input type="hidden" name="group_id" value="{{ $post->group_id }}">
        <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
    </form>
    @endif
</div>
