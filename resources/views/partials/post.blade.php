<div class="bg-gray-800 p-4 rounded-lg space-y-2 post-item">
    <p class="text-white font-bold">{{ $post->user->name }}</p>
    <p class="text-yellow-400 font-semibold">{{ $post->title }}</p>
    <p class="text-gray-300">{{ $post->content }}</p>
    @if($post->image)
        <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-full rounded mb-2">
    @endif

    <div class="flex justify-between items-center mt-2">
        <div class="flex space-x-4">
            <button data-post="{{ $post->id }}" class="like-btn text-white">👍 {{ $post->likes->count() }}</button>
            <span class="comment-count text-gray-300">{{ $post->comments->count() }} comments</span>
        </div>
        @if($post->user_id === auth()->id())
            <button data-post="{{ $post->id }}" class="delete-btn text-red-500">Delete</button>
        @endif
    </div>

    <!-- Comments -->
    <div class="mt-2 comments-container">
        @foreach($post->comments as $comment)
            @include('partials.comment', ['comment' => $comment])
        @endforeach
    </div>

    <!-- Add comment -->
    <form data-post="{{ $post->id }}" class="mt-2 comment-form">
        <input type="text" name="content" placeholder="Add a comment..." class="w-full p-1 rounded bg-black text-yellow-400 border-2 border-yellow-400">
    </form>
</div>
