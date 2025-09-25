@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 space-y-6">

    {{-- Page Header --}}
    <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 shadow-md flex items-center justify-between">
        <h1 class="text-4xl font-extrabold text-gray-900 dark:text-gray-100">Groups</h1>

        <!-- Create Group Button (Visible to all users) -->
        <a href="{{ route('groups.create') }}"
           class="px-5 py-2.5 rounded-full bg-yellow-500 text-white font-bold border border-yellow-400 shadow-md hover:bg-yellow-600 hover:shadow-lg transition flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span>Create Group</span>
        </a>
    </div>

    {{-- Search and Topics Filter --}}
    <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 shadow-md">
        <form method="GET" action="{{ route('groups.index') }}" class="flex items-center gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search groups..."
                   class="flex-1 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600 shadow-sm">
            <button type="submit"
                    class="px-5 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                Search
            </button>
        </form>

        <div class="flex flex-wrap gap-2 mt-4">
            @foreach($topics as $topic)
                <a href="{{ route('groups.index', ['topic' => $topic->id]) }}"
                   class="px-4 py-1.5 rounded-full border cursor-pointer text-sm font-medium
                          {{ request('topic') == $topic->id 
                              ? 'bg-green-200 dark:bg-green-700/70 border-green-300 dark:border-green-600 text-green-800 dark:text-green-100 shadow-sm' 
                              : 'bg-gray-100 dark:bg-gray-700/50 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-green-100 dark:hover:bg-green-600/60 hover:text-green-800 dark:hover:text-green-100' }}
                          transition">
                    {{ $topic->name }}
                </a>
            @endforeach

            @if(request('topic'))
            <a href="{{ route('groups.index') }}"
               class="px-4 py-1.5 rounded-full bg-red-200 dark:bg-red-700/70 
                      border border-red-300 dark:border-red-600 
                      text-red-800 dark:text-red-100 font-medium text-sm 
                      hover:bg-red-300 dark:hover:bg-red-600 transition">
                Clear Filter
            </a>
            @endif
        </div>
    </div>

    {{-- Groups List --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($groups as $group)
        <a href="{{ route('groups.show', $group) }}" 
           class="block p-6 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-md hover:shadow-lg transition duration-200">
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $group->name }}</h2>
            <p class="text-gray-600 dark:text-gray-300 mt-2 line-clamp-2">{{ $group->description ?? 'No description.' }}</p>
            <div class="mt-4 space-y-1 text-sm">
                <p class="text-gray-500 dark:text-gray-400">Created by: <span class="font-medium text-gray-900 dark:text-gray-100">{{ $group->creator->name }}</span></p>
                <p class="text-gray-500 dark:text-gray-400">Topics: <span class="font-medium text-gray-900 dark:text-gray-100">{{ $group->topics->pluck('name')->join(', ') }}</span></p>
                <p class="text-gray-500 dark:text-gray-400">Members: <span class="font-medium text-gray-900 dark:text-gray-100">{{ $group->members->count() }}</span></p>
            </div>

            {{-- Joined badge --}}
            @auth
                @if($group->members->contains(auth()->id()))
                <span class="mt-4 inline-block px-3 py-1 rounded-full bg-green-200 dark:bg-green-700/70 text-green-800 dark:text-green-100 font-semibold text-xs">
                    Joined
                </span>
                @endif
            @endauth
        </a>
        @empty
        <p class="text-gray-500 dark:text-gray-400">No groups yet. Be the first to create one!</p>
        @endforelse
    </div>
</div>
@endsection
