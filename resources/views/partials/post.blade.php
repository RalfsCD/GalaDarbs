<div class="post-item p-4 bg-gray-800 rounded-lg shadow mb-4">
    <div class="flex justify-between mb-2">
        <div>
            <p class="text-yellow-400 font-bold">{{ $post->user->name }}</p>
            <p class="text-gray-400 text-sm">in {{ $post->group->name }}</p>
        </div>
        <span class="text-gray-500 text-xs">{{ $post->created_at->diffForHumans() }}</span>
    </div>

    @if($post->title)
        <h2 class="text-xl font-bold text-white mb-2">{{ $post->title }}</h2>
    @endif

    <p class="text-gray-200 mb-2">{{ $post->content }}</p>

    @if($post->image)
        <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="rounded-lg mb-2">
    @endif

    <div class="flex justify-between text-sm text-gray-400 mt-3">
        <button class="like-btn" data-post="{{ $post->id }}">👍 {{ $post->likes->count() }}</button>
        <span class="comment-count">{{ $post->comments->count() }} {{ Str::plural('comment', $post->comments->count()) }}</span>
    </div>

    <div class="comments-container mt-2">
        @foreach($post->comments as $comment)
            @include('partials.comment', ['comment' => $comment])
        @endforeach
    </div>

    <form class="comment-form mt-2" data-post="{{ $post->id }}">
        @csrf
        <input type="text" name="content" class="w-full p-1 rounded bg-black text-yellow-400 border border-yellow-400" placeholder="Add a comment...">
    </form>

    @if(auth()->id() === $post->user_id)
        <button class="delete-btn mt-2 bg-red-500 px-3 py-1 text-white rounded" data-post="{{ $post->id }}">Delete</button>
    @endif
</div>
