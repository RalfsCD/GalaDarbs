@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 relative">

    <!-- Page Header Card -->
    <div class="p-6 rounded-2xl 
                bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                backdrop-blur-md border border-gray-200 shadow-sm mb-6 flex justify-between items-center">

        <h1 class="text-4xl font-extrabold text-gray-900">Create group</h1>
    </div>

    <form id="createGroupForm" action="{{ route('groups.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Card wrapper -->
        <div class="p-6 rounded-2xl 
                    bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                    backdrop-blur-md border border-gray-200 shadow-sm hover:shadow-md transition space-y-6">

            <!-- Group Name -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Group Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                       class="w-full p-3 rounded-lg bg-white/70 backdrop-blur-sm border border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400" 
                       placeholder="Enter group name">
            </div>

            <!-- Description -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Description (optional)</label>
                <textarea name="description" id="description" rows="4"
                          class="w-full p-3 rounded-lg bg-white/70 backdrop-blur-sm border border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400" 
                          placeholder="Describe your group...">{{ old('description') }}</textarea>
            </div>

            <!-- Topics as Bubbles -->
            <div id="topicsWrapper">
                <label class="block text-gray-700 font-medium mb-2">Topics</label>
                <div class="flex flex-wrap gap-2 mb-2">
                    @foreach($topics as $topic)
                        <div 
                            class="topic-bubble px-3 py-1 rounded-full border border-gray-300 text-gray-700 cursor-pointer select-none hover:bg-gray-100 transition"
                            data-id="{{ $topic->id }}"
                        >
                            {{ $topic->name }}
                        </div>
                    @endforeach
                </div>
                <!-- Container for hidden inputs -->
                <div id="selected-topics-container"></div>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full px-4 py-3 bg-gray-900 text-white font-bold rounded-lg hover:bg-gray-800 transition">
                Create Group
            </button>
        </div>
    </form>

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
    const selectedTopics = @json(old('topics', []));

    const nameInput = document.getElementById('name');
    const topicsWrapper = document.getElementById('topicsWrapper');

    // Topics selection logic
    document.querySelectorAll('.topic-bubble').forEach(bubble => {
        const id = parseInt(bubble.dataset.id);

        if(selectedTopics.includes(id)){
            bubble.classList.add('bg-gray-900', 'text-white');
        }

        bubble.addEventListener('click', function() {
            if(selectedTopics.includes(id)){
                selectedTopics.splice(selectedTopics.indexOf(id), 1);
                this.classList.remove('bg-gray-900', 'text-white');
                this.classList.add('text-gray-700');
            } else {
                selectedTopics.push(id);
                this.classList.add('bg-gray-900', 'text-white');
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

    // Form validation
    document.getElementById('createGroupForm').addEventListener('submit', function(e) {
        const errors = [];
        const name = nameInput.value.trim();

        // Reset previous error styles
        nameInput.classList.remove('border-red-600');
        topicsWrapper.classList.remove('border-red-600', 'p-2', 'rounded-lg');

        if (!name) {
            errors.push("Group name is required.");
            nameInput.classList.add('border-red-600');
        }

        if (selectedTopics.length === 0) {
            errors.push("Please select at least one topic.");
            topicsWrapper.classList.add('border-red-600', 'p-2', 'rounded-lg');
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
