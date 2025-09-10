@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 space-y-6">

    <!-- Page Header -->
    <div class="p-5 rounded-2xl bg-white/30 backdrop-blur-sm border border-gray-200 shadow-sm hover:shadow-md transition">
        <h1 class="text-3xl font-bold text-gray-900">Create Post in {{ $group->name }}</h1>
    </div>

    <!-- Form -->
    <form action="{{ route('posts.store', $group) }}" method="POST" enctype="multipart/form-data" 
          class="p-6 rounded-2xl bg-white/30 backdrop-blur-sm border border-gray-200 shadow-sm hover:shadow-md transition space-y-4">

        @csrf

        <!-- Title -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Title</label>
            <input type="text" name="title" value="{{ old('title') }}" required
                   class="w-full p-3 rounded-lg bg-white/70 backdrop-blur-sm border border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400">
            @error('title') <p class="text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Content -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Content</label>
            <textarea name="content" rows="5"
                      class="w-full p-3 rounded-lg bg-white/70 backdrop-blur-sm border border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400">{{ old('content') }}</textarea>
            @error('content') <p class="text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Media -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Media</label>
            <input type="file" name="media" class="mt-1">
            @error('media') <p class="text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" 
                    class="px-6 py-3 bg-gray-900 text-white font-bold rounded-lg hover:bg-gray-800 transition">
                Create Post
            </button>
        </div>
    </form>

    <!-- Back Link -->
    <div class="flex justify-start mt-4">
        <a href="{{ route('groups.show', $group) }}" 
           class="text-gray-500 hover:text-gray-900 transition">← Back to Group</a>
    </div>
</div>
@endsection
