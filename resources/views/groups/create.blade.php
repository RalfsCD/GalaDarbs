@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">

    <!-- Page Header Card -->
    <div class="p-6 rounded-2xl 
                bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                backdrop-blur-md border border-gray-200 shadow-sm mb-6 flex justify-between items-center">

        <h1 class="text-4xl font-extrabold text-gray-900">Create group</h1>
    </div>

    <form action="{{ route('groups.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Card wrapper -->
        <div class="p-6 rounded-2xl 
                    bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                    backdrop-blur-md border border-gray-200 shadow-sm hover:shadow-md transition space-y-6">

            <!-- Group Name -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Group Name</label>
                <input type="text" name="name" 
                       class="w-full p-3 rounded-lg bg-white/70 backdrop-blur-sm border border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400" 
                       placeholder="Enter group name" required>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Description (optional)</label>
                <textarea name="description" rows="4" 
                          class="w-full p-3 rounded-lg bg-white/70 backdrop-blur-sm border border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400" 
                          placeholder="Describe your group..."></textarea>
            </div>

            <!-- Topics as Bubbles -->
            <div>
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
</div>

<script>
    const selectedTopics = [];

    document.querySelectorAll('.topic-bubble').forEach(bubble => {
        bubble.addEventListener('click', function() {
            const id = this.dataset.id;

            if(selectedTopics.includes(id)){
                // Remove from selected
                selectedTopics.splice(selectedTopics.indexOf(id), 1);
                this.classList.remove('bg-gray-900', 'text-white');
                this.classList.add('text-gray-700');
            } else {
                // Add to selected
                selectedTopics.push(id);
                this.classList.add('bg-gray-900', 'text-white');
            }

            // Clear previous hidden inputs
            const container = document.getElementById('selected-topics-container');
            container.innerHTML = '';

            // Create a hidden input for each selected topic
            selectedTopics.forEach(topicId => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'topics[]';
                input.value = topicId;
                container.appendChild(input);
            });
        });
    });
</script>
@endsection
