@extends('layouts.app')

@section('content')
<div class="min-h-screen flex justify-center p-6">
    <div class="w-full max-w-3xl bg-white/50 backdrop-blur-md border border-gray-200 rounded-3xl p-8 shadow-sm space-y-6">

        <!-- Header -->
        <h1 class="text-3xl font-bold text-gray-900">Add News</h1>

        <!-- Form -->
        <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Title -->
            <div>
                <label for="title" class="block text-gray-900 font-medium">Title</label>
                <input type="text" name="title" id="title" required
                       class="w-full mt-1 px-4 py-2 rounded-lg border-2 border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300"/>
            </div>

            <!-- Image -->
            <div>
                <label for="image" class="block text-gray-900 font-medium">Image (optional)</label>
                <input type="file" name="image" id="image"
                       class="w-full mt-1 px-4 py-2 rounded-lg border-2 border-gray-300 bg-white text-gray-900 file:bg-gray-200 file:border-0 file:px-3 file:py-2 file:rounded-lg file:text-gray-900 hover:file:bg-gray-300 focus:outline-none"/>
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-gray-900 font-medium">Content</label>
                <textarea name="content" id="content" rows="5" required
                          class="w-full mt-1 px-4 py-2 rounded-lg border-2 border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300"></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full px-4 py-3 bg-gray-900 text-white font-bold rounded-lg hover:bg-gray-800 transition">
                Publish
            </button>
        </form>
    </div>
</div>
@endsection
