@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 space-y-6">

    {{-- Page Header --}}
    <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 shadow-md flex items-center justify-between">
        <h1 class="text-4xl font-extrabold text-gray-900 dark:text-gray-100">Topics</h1>

        @if(auth()->check() && auth()->user()->isAdmin())
        <a href="{{ route('topics.create') }}"
           class="px-5 py-2.5 rounded-full bg-yellow-500 text-white font-bold border border-yellow-400 shadow-md hover:bg-yellow-600 hover:shadow-lg transition flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span>Create Topic</span>
        </a>
        @endif
    </div>

    {{-- Search --}}
    <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 shadow-md">
        <form method="GET" action="{{ route('topics.index') }}" class="flex items-center gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search topics..." 
                   class="flex-1 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600 shadow-sm">
            <button type="submit"
                    class="px-5 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                Search
            </button>
        </form>
    </div>

    {{-- Topics List --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($topics as $topic)
        <a href="{{ route('topics.show', $topic) }}" class="block p-6 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-md hover:shadow-lg transition duration-200">
            <h2 class="text-xl text-gray-900 dark:text-gray-100 font-bold">{{ $topic->name }}</h2>
            <p class="text-gray-600 dark:text-gray-300 mt-2 line-clamp-2">
                {{ $topic->description ?? 'No description.' }}
            </p>
            <p class="text-gray-500 text-sm mt-3">{{ $topic->groups_count }} {{ Str::plural('Group', $topic->groups_count) }}</p>
        </a>
        @empty
        <p class="text-gray-500 dark:text-gray-400">No topics yet.</p>
        @endforelse
    </div>
</div>
@endsection
