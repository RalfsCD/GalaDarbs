@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 py-4 sm:py-6 space-y-4 sm:space-y-6">

    {{-- Page Header --}}
    <div class="p-4 sm:p-6 rounded-2xl bg-white dark:bg-gray-800 shadow-md flex items-center justify-between">
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-gray-900 dark:text-gray-100">Topics</h1>

        @if(auth()->check() && auth()->user()->isAdmin())
        <a href="{{ route('topics.create') }}"
           class="px-4 sm:px-5 py-2 sm:py-2.5 rounded-full bg-yellow-500 text-white font-bold border border-yellow-400 shadow-md hover:bg-yellow-600 hover:shadow-lg transition flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span class="hidden xs:inline">Create Topic</span>
            <span class="inline xs:hidden">New</span>
        </a>
        @endif
    </div>

    {{-- Search --}}
    <div class="p-4 sm:p-6 rounded-2xl bg-white dark:bg-gray-800 shadow-md">
        <form method="GET" action="{{ route('topics.index') }}"
              class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <label for="topics-search" class="sr-only">Search topics</label>
            <input id="topics-search" type="search" name="search"
                   value="{{ request('search', '') }}"
                   placeholder="Search topics..."
                   autocomplete="off"
                   class="w-full min-w-0 px-3 sm:px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600
                          bg-white dark:bg-gray-900 text-sm sm:text-base text-gray-900 dark:text-gray-100
                          placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-300
                          dark:focus:ring-yellow-600 shadow-sm" />

            <div class="flex gap-2">
                <button type="submit"
                        class="px-3 sm:px-5 py-2 rounded-lg bg-gray-200 dark:bg-gray-700
                               text-gray-900 dark:text-gray-100 font-medium hover:bg-gray-300
                               dark:hover:bg-gray-600 transition">
                    Search
                </button>

                @if(request()->filled('search'))
                    <a href="{{ route('topics.index') }}"
                       class="px-3 sm:px-4 py-2 rounded-lg border border-transparent
                              bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200
                              hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Topics List --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
        @forelse($topics as $topic)
            <a href="{{ route('topics.show', $topic) }}"
               class="block p-4 sm:p-6 rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700
                      shadow-md hover:shadow-lg transition duration-200">
                <h2 class="text-lg sm:text-xl text-gray-900 dark:text-gray-100 font-bold break-words">
                    {{ $topic->name }}
                </h2>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300 mt-2 line-clamp-2">
                    {{ $topic->description ?? 'No description.' }}
                </p>
                <p class="text-xs sm:text-sm text-gray-500 mt-3">
                    {{ $topic->groups_count }} {{ Str::plural('Group', $topic->groups_count) }}
                </p>
            </a>
        @empty
            <div class="col-span-full p-6 rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-center">
                @if(request()->filled('search'))
                    <p class="text-gray-700 dark:text-gray-300">
                        No topics match <span class="font-semibold">"{{ request('search') }}"</span>.
                    </p>
                    <a href="{{ route('topics.index') }}"
                       class="inline-block mt-3 px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700
                              text-gray-900 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                        Clear search
                    </a>
                @else
                    <p class="text-gray-500 dark:text-gray-400">No topics yet.</p>
                @endif
            </div>
        @endforelse
    </div>

    {{-- Pagination (keeps search param) --}}
    @if(method_exists($topics, 'hasPages') && $topics->hasPages())
        <div class="pt-2">
            {{ $topics->appends(request()->only('search'))->links() }}
        </div>
    @endif
</div>
@endsection
