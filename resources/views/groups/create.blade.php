@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 space-y-6">

    {{-- Page Header --}}
    <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 shadow-md flex items-center justify-between">
        <h1 class="text-4xl font-extrabold text-gray-900 dark:text-gray-100">Create Group</h1>
    </div>

    {{-- Create Group Form --}}
    <form id="createGroupForm" action="{{ route('groups.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 shadow-md border border-gray-200 dark:border-gray-700 hover:shadow-lg transition space-y-6">

            {{-- Group Name --}}
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">Group Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    placeholder="Enter group name"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 
                           bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 
                           placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 dark:focus:ring-yellow-600">
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">Description (optional)</label>
                <textarea name="description" id="description" rows="4"
                          placeholder="Describe your group..."
                          class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 
                                 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 
                                 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 dark:focus:ring-yellow-600">{{ old('description') }}</textarea>
            </div>

            {{-- Topics --}}
            <div id="topicsWrapper">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Topics</label>
                <div class="flex flex-wrap gap-2 mb-2">
                    @foreach($topics as $topic)
                        <div 
                            class="topic-bubble px-4 py-1.5 rounded-full border border-gray-300 dark:border-gray-600 
                                   text-gray-700 dark:text-gray-200 cursor-pointer select-none 
                                   bg-gray-100/60 dark:bg-gray-700/50 hover:bg-yellow-100 dark:hover:bg-yellow-600/70 
                                   transition text-sm font-medium"
                            data-id="{{ $topic->id }}">
                            {{ $topic->name }}
                        </div>
                    @endforeach
                </div>
                <div id="selected-topics-container"></div>
            </div>

            {{-- Submit --}}
            <button type="submit" 
                    class="w-full py-3 px-4 rounded-xl font-semibold 
                           bg-yellow-400 text-gray-900 
                           hover:bg-yellow-500 dark:bg-yellow-500 dark:hover:bg-yellow-400 
                           transition shadow-sm">
                Create Group
            </button>
        </div>
    </form>

    {{-- Validation Modal --}}
    <div id="validationModal" 
         class="fixed inset-0 bg-black/40 dark:bg-black/70 backdrop-blur-sm 
                flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-xl max-w-lg w-full space-y-4 relative">
            <button id="closeModal" 
                    class="absolute top-3 right-3 text-gray-500 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 text-2xl">
                &times;
            </button>
            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">Please fix the following errors:</h2>
            <ul id="errorList" class="list-disc pl-5 text-gray-700 dark:text-gray-200 space-y-1"></ul>
        </div>
    </div>

</div>

{{-- Script --}}
<script>
    const selectedTopics = @json(old('topics', []));
    const nameInput = document.getElementById('name');
    const topicsWrapper = document.getElementById('topicsWrapper');

    // Highlight old selected topics
    document.querySelectorAll('.topic-bubble').forEach(bubble => {
        const id = parseInt(bubble.dataset.id);

        if (selectedTopics.includes(id)) {
            bubble.classList.add('bg-yellow-400', 'text-gray-900', 'dark:bg-yellow-500', 'dark:text-gray-900');
        }

        bubble.addEventListener('click', function () {
            if (selectedTopics.includes(id)) {
                selectedTopics.splice(selectedTopics.indexOf(id), 1);
                this.classList.remove('bg-yellow-400', 'text-gray-900', 'dark:bg-yellow-500', 'dark:text-gray-900');
            } else {
                selectedTopics.push(id);
                this.classList.add('bg-yellow-400', 'text-gray-900', 'dark:bg-yellow-500', 'dark:text-gray-900');
            }
            updateHiddenTopics();
        });
    });

    function updateHiddenTopics() {
        const container = document.getElementById('selected-topics-container');
        container.innerHTML = '';
        selectedTopics.forEach(topicId => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'topics[]';
            input.value = topicId;
            container.appendChild(input);
        });
    }

    updateHiddenTopics();

    // Validation
    document.getElementById('createGroupForm').addEventListener('submit', function(e) {
        const errors = [];
        const name = nameInput.value.trim();

        nameInput.classList.remove('border-red-600');
        topicsWrapper.classList.remove('border-red-600');

        if (!name) {
            errors.push("Group name is required.");
            nameInput.classList.add('border-red-600');
        }

        if (selectedTopics.length === 0) {
            errors.push("Please select at least one topic.");
            topicsWrapper.classList.add('border-red-600');
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
