@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 relative">

    <!-- Page Header Card -->
    <div class="p-6 rounded-2xl 
                bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                backdrop-blur-md border border-gray-200 shadow-sm mb-6 flex items-center">

        <h1 class="text-4xl font-extrabold text-gray-900">
            Create Post in 
            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full font-medium">
                {{ $group->name }}
            </span>
        </h1>
    </div>

    <!-- Form Card -->
    <form id="createPostForm" action="{{ route('posts.store', $group) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="p-6 rounded-2xl 
                    bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                    backdrop-blur-md border border-gray-200 shadow-sm hover:shadow-md transition space-y-6">

            <!-- Title -->
            <div>
                <label for="title" class="block text-gray-700 font-medium mb-1">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}"
                       class="w-full p-3 rounded-lg bg-white/70 backdrop-blur-sm border border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400"/>
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-gray-700 font-medium mb-1">Content</label>
                <textarea name="content" id="content" rows="5"
                          class="w-full p-3 rounded-lg bg-white/70 backdrop-blur-sm border border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400">{{ old('content') }}</textarea>
            </div>

            <!-- Media -->
            <div>
                <label for="media" class="block text-gray-700 font-medium mb-1">Media</label>
                <label 
                    for="media" 
                    class="flex items-center justify-center w-full px-3 py-2 rounded-lg border border-gray-300 bg-white/70 backdrop-blur-sm text-gray-900 cursor-pointer hover:bg-gray-200 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v6m0 0l-3-3m3 3l3-3M4 8V6a2 2 0 012-2h12a2 2 0 012 2v2"/>
                    </svg>
                    <span id="mediaFileName" class="truncate">Choose a file</span>
                </label>
                <input type="file" name="media" id="media" class="hidden"/>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full px-4 py-3 bg-gray-900 text-white font-bold rounded-lg hover:bg-gray-800 transition">
                Create Post
            </button>
        </div>
    </form>

    <!-- Back Link -->
    <div class="mt-4">
        <a href="{{ route('groups.show', $group) }}" 
           class="text-gray-500 hover:text-gray-900 transition">← Back to Group</a>
    </div>

    <!-- Validation Modal -->
    <div id="validationModal" class="fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div class="bg-white p-6 rounded-2xl shadow-lg max-w-lg w-full space-y-4 relative">
            <button id="closeModal" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-2xl">&times;</button>
            <h2 class="text-xl font-bold text-gray-900">Please fix the following errors:</h2>
            <ul id="errorList" class="list-disc pl-5 text-gray-900 space-y-1"></ul>
        </div>
    </div>

</div>

<script>
    // Show selected file name
    const mediaInput = document.getElementById('media');
    const mediaFileName = document.getElementById('mediaFileName');
    mediaInput.addEventListener('change', () => {
        mediaFileName.textContent = mediaInput.files.length > 0 ? mediaInput.files[0].name : 'Choose a file';
    });

    // Form validation
    const form = document.getElementById('createPostForm');
    const titleInput = document.getElementById('title');
    const contentInput = document.getElementById('content');

    form.addEventListener('submit', function(e) {
        const errors = [];

        // Reset borders
        titleInput.classList.remove('border-red-600');
        contentInput.classList.remove('border-red-600');

        if (!titleInput.value.trim()) {
            errors.push("Title is required.");
            titleInput.classList.add('border-red-600');
        }

        if (!contentInput.value.trim()) {
            errors.push("Content is required.");
            contentInput.classList.add('border-red-600');
        }

        if (errors.length > 0) {
            e.preventDefault();
            const errorList = document.getElementById('errorList');
            errorList.innerHTML = '';
            errors.forEach(err => {
                const li = document.createElement('li');
                li.textContent = err;
                errorList.appendChild(li);
            });
            document.getElementById('validationModal').classList.remove('hidden');
        }
    });

    // Close modal
    document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('validationModal').classList.add('hidden');
    });
</script>
@endsection
