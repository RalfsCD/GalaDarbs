@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 relative">


    <div class="p-6 rounded-2xl 
                bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                backdrop-blur-md border border-gray-200 shadow-sm mb-6 flex justify-between items-center">

        <h1 class="text-4xl font-extrabold text-gray-900">Create Topic</h1>
    </div>


    <form id="createTopicForm" action="{{ route('topics.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="p-6 rounded-2xl 
                    bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                    backdrop-blur-md border border-gray-200 shadow-sm hover:shadow-md transition space-y-6">


            <div>
                <label for="name" class="block text-gray-700 font-medium mb-1">Topic Name</label>
                <input type="text" name="name" id="name"
                    class="w-full p-3 rounded-lg bg-white/70 backdrop-blur-sm border border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400"
                    placeholder="Enter topic name">
            </div>


            <div>
                <label for="description" class="block text-gray-700 font-medium mb-1">Description (optional)</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full p-3 rounded-lg bg-white/70 backdrop-blur-sm border border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400"
                    placeholder="Describe your topic..."></textarea>
            </div>


            <button type="submit"
                class="w-full px-4 py-3 bg-gray-900 text-white font-bold rounded-lg hover:bg-gray-800 transition">
                Create Topic
            </button>
        </div>
    </form>

    <!-- Validacijas logs -->
    <div id="validationModal" class="fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div class="bg-white p-6 rounded-2xl shadow-lg max-w-lg w-full space-y-4 relative">
            <button id="closeModal" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-2xl">&times;</button>
            <h2 class="text-xl font-bold text-gray-900">Please fix the following errors:</h2>
            <ul id="errorList" class="list-disc pl-5 text-gray-900 space-y-1"></ul>
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