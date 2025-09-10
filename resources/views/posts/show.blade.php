@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 space-y-6">

    <div class="post-item bg-gray-900 p-4 rounded-2xl shadow-lg" id="post-{{ $post->id }}">
        <h1 class="text-2xl text-yellow-400 font-bold">{{ $post->title }}</h1>
        <p class="text-gray-300 mt-1">{{ $post->content }}</p>

        @if($post->media_path)
            <img src="{{ asset('storage/' . $post->media_path) }}" 
                 alt="Post Image" 
                 class="rounded-lg mt-3 max-w-full h-auto">
        @endif

        <p class="text-gray-400 mt-2 text-sm">Posted by {{ $post->user->name }} in {{ $post->group->name }}</p>

        {{-- Likes and Comments --}}
        @php
            $isOwner  = auth()->check() && auth()->id() === $post->user_id;
        @endphp
        <div class="flex items-center gap-4 mt-3">
            <button type="button"
                    class="like-btn text-yellow-400 hover:text-yellow-300 {{ auth()->check() && $post->likes->contains(auth()->id()) ? 'liked' : '' }}"
                    data-post="{{ $post->id }}">
                ❤️ <span class="like-count">{{ $post->likes_count ?? $post->likes->count() }}</span>
            </button>

            <span class="text-gray-400 comment-count">
                {{ $post->comments_count ?? $post->comments->count() }}
                {{ ($post->comments_count ?? $post->comments->count()) === 1 ? 'comment' : 'comments' }}
            </span>

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

        {{-- Comments --}}
        <div class="comments-container mt-3 space-y-2">
            @foreach($post->comments as $comment)
                @include('partials.comment', ['comment' => $comment])
            @endforeach
        </div>

        {{-- Comment Form --}}
        <form class="comment-form mt-3" data-post="{{ $post->id }}">
            @csrf
            <input name="content" required
                   class="w-full p-2 rounded bg-black text-yellow-400 border-2 border-yellow-400"
                   placeholder="Write a comment...">
        </form>
    </div>
</div>

@include('partials.post-scripts', ['groupId' => $post->group_id])
@endsection
