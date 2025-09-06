@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-3xl font-bold text-yellow-400 mb-6">Create Group</h1>

    <form action="{{ route('groups.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Group Name -->
        <div>
            <label class="block text-yellow-400 mb-1">Group Name</label>
            <input type="text" name="name" required
                class="w-full p-2 rounded bg-black border-2 border-yellow-400 text-yellow-400
                       focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400" />
        </div>

        <!-- Description -->
        <div>
            <label class="block text-yellow-400 mb-1">Description (optional)</label>
            <textarea name="description" rows="3"
                class="w-full p-2 rounded bg-black border-2 border-yellow-400 text-yellow-400
                       focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400"></textarea>
        </div>

        <!-- Topics -->
        <div>
            <label class="block text-yellow-400 mb-2">Topics</label>
            <div class="flex flex-wrap gap-2">
                @foreach($topics as $topic)
                    <div class="topic-bubble cursor-pointer rounded-full border-2 border-yellow-400 px-4 py-1 text-yellow-400 select-none transition-colors duration-200"
                         data-id="{{ $topic->id }}">
                        {{ $topic->name }}
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Hidden input for selected topics -->
        <input type="hidden" name="topics[]" id="selectedTopics">

        <!-- Submit Button -->
        <button type="submit" class="bg-yellow-400 text-black px-4 py-2 rounded font-bold hover:bg-yellow-300">
            Create Group
        </button>
    </form>
</div>

<script>
    const bubbles = document.querySelectorAll('.topic-bubble');
    const hiddenInput = document.getElementById('selectedTopics');
    let selectedTopics = [];

    bubbles.forEach(bubble => {
        bubble.addEventListener('click', () => {
            const topicId = bubble.dataset.id;

            if (selectedTopics.includes(topicId)) {
                // Deselect
                selectedTopics = selectedTopics.filter(id => id !== topicId);
                bubble.classList.remove('bg-yellow-400', 'text-black');
                bubble.classList.add('text-yellow-400');
            } else {
                // Select
                selectedTopics.push(topicId);
                bubble.classList.add('bg-yellow-400', 'text-black');
                bubble.classList.remove('text-yellow-400');
            }

            // Update hidden input
            hiddenInput.value = selectedTopics;
        });
    });
</script>

<style>
    .topic-bubble:hover {
        background-color: yellow;
        color: black;
    }
</style>
@endsection
