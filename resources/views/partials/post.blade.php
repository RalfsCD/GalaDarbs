
@php
    /** @var \App\Models\Post $post */
    $isOwner  = auth()->check() && (int) auth()->id() === (int) $post->user_id;
@endphp

<div class="post-item bg-gray-800 p-4 rounded mb-4" id="post-{{ $post->id }}">
    <div class="flex justify-between items-center">
        <div class="text-yellow-400 font-bold">
            {{ $post->user->name ?? 'Unknown' }}
        </div>

      @if($isOwner)
<form action="{{ route('posts.destroy', $post->id) }}" method="POST"
      onsubmit="return confirm('Are you sure you want to delete this post?');">
    @csrf
    @method('DELETE')
    <input type="hidden" name="group_id" value="{{ $post->group_id }}">
    <button type="submit" class="text-red-500 hover:text-red-700">
        Delete
    </button>
</form>
@endif

    </div>

    <h3 class="text-xl font-semibold text-white mt-2">{{ $post->title }}</h3>

    @if(filled($post->content))
        <p class="text-gray-300 mt-1">{{ $post->content }}</p>
    @endif

    @if($post->media_url)
    <div class="mt-3">
        <img src="{{ asset('storage/' . $post->media_url) }}" 
             alt="Post image" 
             class="rounded-lg max-w-full h-auto">
    </div>
@endif

    <div class="mt-3 flex items-center gap-4">
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

    <div class="comments-container mt-3 space-y-2">
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
</div>
