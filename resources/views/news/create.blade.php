@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">

    <!-- Page Header Card -->
    <div class="p-6 rounded-2xl 
                bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                backdrop-blur-md border border-gray-200 shadow-sm mb-6 flex justify-between items-center">

        <h1 class="text-4xl font-extrabold text-gray-900">Add News</h1>
    </div>

    <!-- Form Card -->
    <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="p-6 rounded-2xl 
                    bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                    backdrop-blur-md border border-gray-200 shadow-sm hover:shadow-md transition space-y-6">

            <!-- Title -->
            <div>
                <label for="title" class="block text-gray-700 font-medium mb-1">Title</label>
                <input type="text" name="title" id="title" required
                       class="w-full p-3 rounded-lg bg-white/70 backdrop-blur-sm border border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400" 
                       placeholder="Enter news title">
            </div>

            <!-- Image -->
            <div>
                <label for="image" class="block text-gray-700 font-medium mb-1">Image (optional)</label>
                <input type="file" name="image" id="image"
                       class="w-full p-3 rounded-lg bg-white/70 backdrop-blur-sm border border-gray-300 text-gray-900 placeholder-gray-400 file:bg-gray-200 file:border-0 file:px-3 file:py-2 file:rounded-lg file:text-gray-900 hover:file:bg-gray-300 focus:outline-none"/>
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-gray-700 font-medium mb-1">Content</label>
                <textarea name="content" id="content" rows="5" required
                          class="w-full p-3 rounded-lg bg-white/70 backdrop-blur-sm border border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400" 
                          placeholder="Write news content..."></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full px-4 py-3 bg-gray-900 text-white font-bold rounded-lg hover:bg-gray-800 transition">
                Publish
            </button>
        </div>
    </form>
</div>
@endsection
