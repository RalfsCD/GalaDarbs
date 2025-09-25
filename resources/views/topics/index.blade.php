@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 space-y-6">

    {{-- Page Header (Title + Add Button) --}}
    <div class="p-6 rounded-2xl 
                bg-gradient-to-r from-white/50 via-gray-50/70 to-white/50
                backdrop-blur-md border border-gray-200 shadow-md 
                flex items-center justify-between">
        <h1 class="text-4xl font-extrabold text-gray-900">Topics</h1>

        @if(auth()->check() && auth()->user()->isAdmin())
        <a href="{{ route('topics.create') }}"
           class="px-5 py-2.5 rounded-full bg-yellow-100 text-yellow-800 font-bold 
                  border border-yellow-200 shadow-sm hover:bg-yellow-200 hover:shadow-md 
                  transition flex items-center gap-2">
            <img src="{{ asset('icons/add.svg') }}" alt="Add" class="w-5 h-5">
            <span>Add Topic</span>
        </a>
        @endif
    </div>

    {{-- Topics List --}}
    <div class="grid gap-6 sm:grid-cols-2">
        @forelse($topics as $topic)
        <a href="{{ route('topics.show', $topic) }}" 
           class="block group p-6 rounded-2xl 
                  bg-gradient-to-r from-white/40 via-gray-50/60 to-white/40
                  backdrop-blur-md border border-gray-200 shadow-sm 
                  hover:shadow-lg hover:scale-[1.01] transition transform duration-200">

            <h2 class="text-xl text-gray-900 font-bold group-hover:text-gray-700 transition">
                {{ $topic->name }}
            </h2>
            <p class="text-gray-600 mt-2 line-clamp-2">
                {{ $topic->description ?? 'No description.' }}
            </p>
            <p class="text-gray-500 text-sm mt-3">
                {{ $topic->groups_count }} {{ Str::plural('Group', $topic->groups_count) }}
            </p>
        </a>
        @empty
        <p class="text-gray-500">No topics yet.</p>
        @endforelse
    </div>
</div>
@endsection
