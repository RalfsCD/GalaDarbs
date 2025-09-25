@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 space-y-6">

    {{-- Page Header --}}
    <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 shadow-md flex items-center justify-between">
        <h1 class="text-4xl font-extrabold text-gray-900 dark:text-gray-100">Add News</h1>
    </div>

    {{-- News Creation Form --}}
    <form id="createNewsForm" action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Title --}}
        <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 shadow-md border border-gray-200 dark:border-gray-700 hover:shadow-lg transition space-y-6">
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}"
                    placeholder="Enter news title"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 
                           bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 
                           placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 dark:focus:ring-yellow-600">
            </div>

            {{-- Image --}}
           <div>
                <label for="media" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">Media (optional)</label>
                <label for="media" class="flex items-center justify-center w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 
                                        bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v6m0 0l-3-3m3 3l3-3M4 8V6a2 2 0 012-2h12a2 2 0 012 2v2"/>
                    </svg>
                    <span id="mediaFileName" class="truncate">Choose a file</span>
                </label>
                <input type="file" name="media" id="media" class="hidden"/>
            </div>

            {{-- Content --}}
            <div>
                <label for="content" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">Content</label>
                <textarea name="content" id="content" rows="5"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 
                           bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 
                           placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 dark:focus:ring-yellow-600"
                    placeholder="Write news content...">{{ old('content') }}</textarea>
            </div>

            <button type="submit" 
                    class="w-full py-3 px-4 rounded-xl font-semibold 
                           bg-yellow-400 text-gray-900 
                           hover:bg-yellow-500 dark:bg-yellow-500 dark:hover:bg-yellow-400 
                           transition shadow-sm">
                Publish
            </button>
        </div>
    </form>

    {{-- Validation Modal --}}
    <div id="validationModal" class="fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div class="bg-white p-6 rounded-2xl shadow-lg max-w-lg w-full space-y-4 relative">
            <button id="closeModal" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-2xl">&times;</button>
            <h2 class="text-xl font-bold text-gray-900">Please fix the following errors:</h2>
            <ul id="errorList" class="list-disc pl-5 text-gray-900 space-y-1"></ul>
        </div>
    </div>

</div>

<script>
    // Handle file name display for selected image
    const imageInput = document.getElementById('media');
    const imageFileName = document.getElementById('mediaFileName');
    imageInput.addEventListener('change', () => {
        imageFileName.textContent = imageInput.files.length > 0 ? imageInput.files[0].name : 'Choose a file';
    });

    // Handle form validation
    const form = document.getElementById('createNewsForm');
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

    document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('validationModal').classList.add('hidden');
    });
</script>
@endsection
