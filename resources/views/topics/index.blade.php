@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Topics</h1>

    @if(auth()->check() && auth()->user()->isAdmin())
        <a href="{{ route('topics.create') }}" 
           class="px-4 py-2 rounded-full border-2 border-gray-300 bg-gray-200 text-gray-900 font-bold hover:bg-gray-300 transition mb-4 inline-block">
           + Add Topic
        </a>
    @endif

    <div class="space-y-6">
        @forelse($topics as $topic)
            <div class="p-4 rounded-2xl 
                        bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                        backdrop-blur-md border border-gray-200 shadow-sm hover:shadow-md transition">

                <h2 class="text-xl text-gray-900 font-bold">
                    <a href="{{ route('topics.show', $topic) }}" class="hover:text-gray-700">
                        {{ $topic->name }}
                    </a>
                </h2>
                <p class="text-gray-600 mt-1">{{ $topic->description ?? 'No description.' }}</p>
                <p class="text-gray-500 text-sm mt-2">{{ $topic->groups_count }} Groups</p>
            </div>
        @empty
            <p class="text-gray-500">No topics yet.</p>
        @endforelse
    </div>
</div>
@endsection
