@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold text-yellow-400 mb-6">Create Group</h1>

    <form action="{{ route('groups.store') }}" method="POST" class="space-y-4" id="create-group-form">
        @csrf
        <div>
            <label class="block text-white">Group Name</label>
            <input type="text" name="name" class="w-full p-2 rounded bg-gray-800 text-white" required>
        </div>

        <div>
            <label class="block text-white">Description (optional)</label>
            <textarea name="description" rows="3" class="w-full p-2 rounded bg-gray-800 text-white"></textarea>
        </div>

        <div>
            <label class="block text-white mb-2">Topics</label>
            <div id="topics-container" class="flex flex-wrap gap-2">
                @foreach($topics as $topic)
                    <div class="topic-bubble cursor-pointer px-4 py-2 rounded-full border border-yellow-400 text-white" 
                         data-id="{{ $topic->id }}">
                        {{ $topic->name }}
                    </div>
                @endforeach
            </div>
            <!-- Hidden inputs for selected topics -->
            <div id="selected-topics"></div>
        </div>

        <button type="submit" class="bg-yellow-400 text-black px-4 py-2 rounded font-bold hover:bg-yellow-300">
            Create Group
        </button>
    </form>
</div>

<script>
    const selectedTopicsContainer = document.getElementById('selected-topics');
    const bubbles = document.querySelectorAll('.topic-bubble');

    bubbles.forEach(bubble => {
        bubble.addEventListener('click', function () {
            const topicId = this.dataset.id;

            // Toggle active class
            this.classList.toggle('bg-yellow-400');
            this.classList.toggle('text-black');

            // Add/remove hidden input
            if (this.classList.contains('bg-yellow-400')) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'topics[]';
                input.value = topicId;
                input.id = 'topic-input-' + topicId;
                selectedTopicsContainer.appendChild(input);
            } else {
                const input = document.getElementById('topic-input-' + topicId);
                if (input) input.remove();
            }
        });
    });
</script>

<style>
    .topic-bubble {
        transition: all 0.2s ease;
    }
    .topic-bubble:hover {
        transform: scale(1.05);
    }
</style>
@endsection
