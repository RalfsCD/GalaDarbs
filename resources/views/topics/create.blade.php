@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6">
    <h1 class="text-2xl font-bold text-yellow-400 mb-6">Create Topic</h1>

    <form action="{{ route('topics.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-white">Name</label>
            <input type="text" name="name" 
                   class="w-full p-2 rounded bg-gray-800 text-white" required>
        </div>

        <div>
            <label class="block text-white">Description</label>
            <textarea name="description" rows="3" 
                      class="w-full p-2 rounded bg-gray-800 text-white"></textarea>
        </div>

        <button type="submit" class="bg-yellow-400 text-black px-4 py-2 rounded font-bold hover:bg-yellow-300">
            Create
        </button>
    </form>
</div>
@endsection
