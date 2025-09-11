@extends('layouts.app')

@section('content')
<div class="min-h-screen flex justify-center p-6">
    <div class="w-full max-w-3xl bg-white/50 backdrop-blur-md border border-gray-200 rounded-3xl p-8 shadow-sm space-y-6">

        <!-- Page Header -->
        <h1 class="text-3xl font-bold text-gray-900">Create Post in {{ $group->name }}</h1>

        <!-- Form -->
        <form action="{{ route('posts.store', $group) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Title -->
            <div>
                <label for="title" class="block text-gray-900 font-medium">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                       class="w-full mt-1 px-4 py-2 rounded-lg border-2 border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300"/>
                @error('title') 
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-gray-900 font-medium">Content</label>
                <textarea name="content" id="content" rows="5"
                          class="w-full mt-1 px-4 py-2 rounded-lg border-2 border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">{{ old('content') }}</textarea>
                @error('content') 
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Media -->
            <div>
                <label for="media" class="block text-gray-900 font-medium">Media</label>
                <input type="file" name="media" id="media"
                       class="w-full mt-1 px-4 py-2 rounded-lg border-2 border-gray-300 bg-white text-gray-900 file:bg-gray-200 file:border-0 file:px-3 file:py-2 file:rounded-lg file:text-gray-900 hover:file:bg-gray-300 focus:outline-none"/>
                @error('media') 
                    <p class="text-red-500 mt-1 text-sm">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full px-4 py-3 bg-gray-900 text-white font-bold rounded-lg hover:bg-gray-800 transition">
                Create Post
            </button>
        </form>

        <!-- Back Link -->
        <div class="flex justify-start">
            <a href="{{ route('groups.show', $group) }}" 
               class="text-gray-500 hover:text-gray-900 transition">← Back to Group</a>
        </div>
    </div>
</div>
@endsection
