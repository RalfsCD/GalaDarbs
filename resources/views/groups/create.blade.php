@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold text-yellow-400 mb-6">Create Group</h1>

    <form action="{{ route('groups.store') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Group Name -->
        <div>
            <label class="block text-yellow-400">Group Name</label>
            <input type="text" name="name" class="w-full p-2 rounded bg-black text-yellow-400 border-2 border-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-400" required>
        </div>

        <!-- Description -->
        <div>
            <label class="block text-yellow-400">Description (optional)</label>
            <textarea name="description" rows="3" class="w-full p-2 rounded bg-black text-yellow-400 border-2 border-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-400"></textarea>
        </div>

        <!-- Topics as Bubbles -->
        <div>
            <label class="block text-yellow-400 mb-2">Topics</label>
            <div class="flex flex-wrap gap-2 mb-2">
                @foreach($topics as $topic)
                    <div 
                        class="topic-bubble px-3 py-1 rounded-full border-2 border-yellow-400 text-yellow-400 cursor-pointer select-none"
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
        <button type="submit" class="bg-yellow-400 text-black px-4 py-2 rounded font-bold hover:bg-yellow-300">
            Create Group
        </button>
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
                this.classList.remove('bg-yellow-400', 'text-black');
                this.classList.add('text-yellow-400');
            } else {
                // Add to selected
                selectedTopics.push(id);
                this.classList.add('bg-yellow-400', 'text-black');
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
