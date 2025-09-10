@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 space-y-6">

    <div class="bg-gray-900 border border-gray-700 p-5 rounded-2xl shadow-lg">
        <h1 class="text-3xl text-yellow-400 font-bold">Create Post in {{ $group->name }}</h1>
    </div>

    <form action="{{ route('posts.store', $group) }}" method="POST" enctype="multipart/form-data" class="bg-gray-800 p-6 rounded-xl shadow border border-gray-700 space-y-4">
        @csrf

        <div>
            <label class="text-yellow-400 font-bold">Title</label>
            <input type="text" name="title" value="{{ old('title') }}" required
                   class="w-full p-2 mt-1 rounded bg-black text-yellow-400 border-2 border-yellow-400">
            @error('title') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-yellow-400 font-bold">Content</label>
            <textarea name="content" rows="5" class="w-full p-2 mt-1 rounded bg-black text-yellow-400 border-2 border-yellow-400">{{ old('content') }}</textarea>
            @error('content') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-yellow-400 font-bold">Media</label>
            <input type="file" name="media" class="mt-1">
            @error('media') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-yellow-400 text-black px-6 py-2 rounded font-bold hover:bg-yellow-300">
                Create Post
            </button>
        </div>
    </form>

    <div class="flex justify-start mt-4">
        <a href="{{ route('groups.show', $group) }}" class="text-gray-400 hover:text-yellow-400">← Back to Group</a>
    </div>
</div>
@endsection
