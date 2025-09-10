@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 space-y-6">

    <div class="bg-gray-900 border border-gray-700 p-5 rounded-2xl shadow-lg">
        <h1 class="text-3xl text-yellow-400 font-bold">{{ $group->name }}</h1>
        <p class="text-gray-300 mt-1">{{ $group->description }}</p>
    </div>

    <div class="bg-gray-800 p-4 rounded-xl shadow border border-gray-700">
        <form id="create-post-form" enctype="multipart/form-data">
            @csrf
            <input type="text" name="title" placeholder="Post title..." 
                   class="w-full p-2 mb-2 rounded bg-black text-yellow-400 border-2 border-yellow-400" required>
            <textarea name="content" rows="3" placeholder="Content..." 
                      class="w-full p-2 mb-2 rounded bg-black text-yellow-400 border-2 border-yellow-400"></textarea>
            <input type="file" name="media" class="mb-2">
            <button class="bg-yellow-400 text-black px-4 py-2 rounded font-bold">Post</button>
        </form>
    </div>

    <div class="flex justify-end mb-2">
        <select id="sort-posts" class="bg-gray-900 text-yellow-400 p-2 rounded border border-gray-700">
            <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest First</option>
            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
            <option value="most_liked" {{ request('sort') === 'most_liked' ? 'selected' : '' }}>Most Liked</option>
        </select>
    </div>

    <div id="posts-container" class="space-y-6">
        @foreach($posts as $post)
            <a href="{{ route('posts.show', $post) }}" class="block group">
                @include('partials.post', ['post' => $post])
            </a>
        @endforeach
    </div>
</div>

@include('partials.post-scripts', ['groupId' => $group->id])
@endsection
