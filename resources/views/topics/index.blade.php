@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 space-y-6">

    {{-- Page Header (Title + Add Button) in Card --}}
    <div class="p-6 rounded-2xl bg-white/70 backdrop-blur-sm border border-gray-200 shadow-sm flex items-center justify-between">
        <h1 class="text-4xl font-extrabold text-gray-900">Topics</h1>


        @if(auth()->check() && auth()->user()->isAdmin())
        <a href="{{ route('topics.create') }}"
            class="px-4 py-2 rounded-full border-2 border-gray-300 bg-gray-200 text-gray-900 font-bold hover:bg-gray-300 transition flex items-center gap-2">

            <img src="{{ asset('icons/add.svg') }}" alt="Add" class="w-5 h-5">
            <span>Add Topic</span>
        </a>
        @endif
    </div>

    {{-- Topics List --}}
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