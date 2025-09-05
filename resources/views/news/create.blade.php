@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold text-yellow-400 mb-6">Add News</h1>

    <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="block text-white">Title</label>
            <input type="text" name="title" class="w-full p-2 rounded bg-gray-800 text-white" required>
        </div>

        <div>
            <label class="block text-white">Image (optional)</label>
            <input type="file" name="image" class="w-full p-2 rounded bg-gray-800 text-white">
        </div>

        <div>
            <label class="block text-white">Content</label>
            <textarea name="content" rows="5" class="w-full p-2 rounded bg-gray-800 text-white" required></textarea>
        </div>

        <button type="submit" class="bg-yellow-400 text-black px-4 py-2 rounded font-bold hover:bg-yellow-300">
            Publish
        </button>
    </form>
</div>
@endsection
