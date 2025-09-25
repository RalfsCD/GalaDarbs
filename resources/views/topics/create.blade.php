@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 space-y-6">

    {{-- Page Header --}}
    <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 shadow-md flex items-center justify-between">
        <h1 class="text-4xl font-extrabold text-gray-900 dark:text-gray-100">Create Topic</h1>
    </div>

    {{-- Create Topic Form --}}
    <form id="createTopicForm" action="{{ route('topics.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 shadow-md border border-gray-200 dark:border-gray-700 hover:shadow-lg transition space-y-6">

            <div>
                <label for="name" class="block text-gray-700 dark:text-gray-100 font-medium mb-1">Topic Name</label>
                <input type="text" name="name" id="name"
                    class="w-full p-3 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600"
                    placeholder="Enter topic name">
            </div>

            <div>
                <label for="description" class="block text-gray-700 dark:text-gray-100 font-medium mb-1">Description (optional)</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full p-3 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600"
                    placeholder="Describe your topic..."></textarea>
            </div>

           <button type="submit" 
                    class="w-full py-3 px-4 rounded-xl font-semibold 
                           bg-yellow-400 text-gray-900 
                           hover:bg-yellow-500 dark:bg-yellow-500 dark:hover:bg-yellow-400 
                           transition shadow-sm">
                Create Topic
            </button>
        </div>
    </form>

    <!-- Validation Modal -->
    <div id="validationModal" class="fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-lg max-w-lg w-full space-y-4 relative">
            <button id="closeModal" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-2xl">&times;</button>
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Please fix the following errors:</h2>
            <ul id="errorList" class="list-disc pl-5 text-gray-900 dark:text-gray-300 space-y-1"></ul>
        </div>
    </div>

</div>

<script>
    const form = document.getElementById('createTopicForm');
    const nameInput = document.getElementById('name');

    form.addEventListener('submit', function(e) {
        const errors = [];

        nameInput.classList.remove('border-red-600');

        if (!nameInput.value.trim()) {
            errors.push("Topic Name is required.");
            nameInput.classList.add('border-red-600');
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
