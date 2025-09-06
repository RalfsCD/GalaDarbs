@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold text-yellow-400 mb-6">Create Group</h1>

    <form action="{{ route('groups.store') }}" method="POST" class="space-y-4">
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
            <label class="block text-white">Topics</label>
            <select name="topics[]" multiple class="w-full p-2 rounded bg-gray-800 text-white">
                @foreach($topics as $topic)
                    <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-yellow-400 text-black px-4 py-2 rounded font-bold hover:bg-yellow-300">
            Create Group
        </button>
    </form>
</div>
@endsection
