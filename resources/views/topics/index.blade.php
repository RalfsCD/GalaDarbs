@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-3xl font-bold text-yellow-400 mb-6">Topics</h1>

    @if(auth()->check() && auth()->user()->isAdmin())
        <a href="{{ route('topics.create') }}" 
           class="bg-yellow-400 text-black px-4 py-2 rounded font-bold hover:bg-yellow-300 mb-4 inline-block">
           + Add Topic
        </a>
    @endif

    <div class="space-y-6">
        @forelse($topics as $topic)
            <div class="p-4 bg-gray-800 rounded-lg">
                <h2 class="text-xl text-white font-bold">
                    <a href="{{ route('topics.show', $topic) }}" class="hover:text-yellow-400">
                        {{ $topic->name }}
                    </a>
                </h2>
                <p class="text-gray-300">{{ $topic->description ?? 'No description.' }}</p>
                <p class="text-gray-400 text-sm mt-2">{{ $topic->groups_count }} Groups</p>
            </div>
        @empty
            <p class="text-gray-400">No topics yet.</p>
        @endforelse
    </div>
</div>
@endsection
