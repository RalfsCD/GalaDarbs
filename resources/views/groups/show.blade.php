@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 space-y-6">

    <!-- Group Info -->
    <div class="bg-gray-800 p-4 rounded-lg">
        <h1 class="text-3xl text-yellow-400 font-bold">{{ $group->name }}</h1>
        <p class="text-gray-300">{{ $group->description }}</p>
    </div>

    <!-- Create Post -->
    <div class="bg-gray-700 p-4 rounded-lg">
        <form action="{{ route('posts.store', $group) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="text" name="title" placeholder="Post title..." class="w-full p-2 mb-2 rounded bg-black text-yellow-400 border-2 border-yellow-400">
            <textarea name="content" rows="3" placeholder="Content..." class="w-full p-2 mb-2 rounded bg-black text-yellow-400 border-2 border-yellow-400"></textarea>
            <input type="file" name="media" class="mb-2">
            <button class="bg-yellow-400 text-black px-4 py-2 rounded font-bold">Post</button>
        </form>
    </div>

    <!-- Posts Feed -->
    @forelse($group->posts as $post)
        <div class="bg-gray-800 p-4 rounded-lg space-y-2">
            <p class="text-white font-bold">{{ $post->user->name }}</p>
            <p class="text-yellow-400 font-semibold">{{ $post->title }}</p>
            <p class="text-gray-300">{{ $post->content }}</p>
            @if($post->media_path)
                <img src="{{ asset('storage/'.$post->media_path) }}" class="w-full rounded">
            @endif

            <!-- Likes / Comments -->
            <div class="flex space-x-4 mt-2">
                <form action="{{ route('posts.like', $post) }}" method="POST">
                    @csrf
                    <button class="text-white">👍 {{ $post->likes->count() }}</button>
                </form>
                <span class="text-gray-300">{{ $post->comments->count() }} comments</span>
            </div>

            <!-- Comments -->
            <div class="mt-2">
                @foreach($post->comments as $comment)
                    <p class="text-gray-300"><span class="font-bold text-white">{{ $comment->user->name }}:</span> {{ $comment->content }}</p>
                @endforeach
                <form action="{{ route('posts.comment', $post) }}" method="POST" class="mt-2">
                    @csrf
                    <input type="text" name="content" placeholder="Add a comment..." class="w-full p-1 rounded bg-black text-yellow-400 border-2 border-yellow-400">
                </form>
            </div>
        </div>
    @empty
        <p class="text-gray-400">No posts yet. Be the first to post!</p>
    @endforelse
</div>
@endsection
