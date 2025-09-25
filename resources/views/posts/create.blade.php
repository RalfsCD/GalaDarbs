@extends('layouts.app')

@section('head')
<style>
    html, body {
        height: 100%;
        overflow: hidden; /* disable scrolling */
    }
    main {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        padding-top: 0 !important; /* remove extra padding */
    }
</style>
@endsection

@section('content')
<div class="ml-64 flex justify-center items-center w-[calc(100%-16rem)] h-full"> {{-- offset by navbar width --}}
    <div class="max-w-2xl w-full space-y-6">

        <!-- Page Header -->
        <div class="p-6 rounded-2xl 
                    bg-white/70 dark:bg-gray-800/70 backdrop-blur-md 
                    border border-gray-200 dark:border-gray-700 shadow-sm flex items-center justify-between">

            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100">
                Create Post in 
                <span class="text-yellow-500">{{ $group->name }}</span>
            </h1>
        </div>

        <!-- Form Card -->
        <form id="createPostForm" action="{{ route('posts.store', $group) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="p-6 rounded-2xl 
                        bg-white/70 dark:bg-gray-800/70 backdrop-blur-md 
                        border border-gray-200 dark:border-gray-700 shadow-sm space-y-6">

                <!-- Title -->
                <div>
                    <label for="title" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                           class="w-full p-3 rounded-lg bg-white/80 dark:bg-gray-900 border border-gray-300 dark:border-gray-600 
                                  text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 
                                  focus:ring-yellow-400"/>
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Content</label>
                    <textarea name="content" id="content" rows="5"
                              class="w-full p-3 rounded-lg bg-white/80 dark:bg-gray-900 border border-gray-300 dark:border-gray-600 
                                     text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 
                                     focus:ring-yellow-400">{{ old('content') }}</textarea>
                </div>

                <!-- Media -->
                <div>
                    <label for="media" class="block text-gray-700 dark:text-gray-300 font-medium mb-1">Media</label>
                    <label 
                        for="media" 
                        class="flex items-center justify-center w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 
                               bg-white/80 dark:bg-gray-900 text-gray-900 dark:text-gray-100 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v6m0 0l-3-3m3 3l3-3M4 8V6a2 2 0 012-2h12a2 2 0 012 2v2"/>
                        </svg>
                        <span id="mediaFileName" class="truncate">Choose a file</span>
                    </label>
                    <input type="file" name="media" id="media" class="hidden"/>
                </div>

                <!-- Submit -->
                <button type="submit" 
                        class="w-full px-4 py-3 bg-yellow-500 text-gray-900 font-bold rounded-lg hover:bg-yellow-600 transition">
                    Create Post
                </button>
            </div>
        </form>

        <!-- Validation Modal -->
        <div id="validationModal" class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex items-center justify-center z-50 hidden">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg max-w-lg w-full space-y-4 relative">
                <button id="closeModal" class="absolute top-3 right-3 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white text-2xl">&times;</button>
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Please fix the following errors:</h2>
                <ul id="errorList" class="list-disc pl-5 text-gray-900 dark:text-gray-100 space-y-1"></ul>
            </div>
        </div>

    </div>
</div>

<script>
    // File name preview
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
