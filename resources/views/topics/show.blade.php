@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 space-y-6">

    {{-- Topic Header --}}
    <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-md">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100">{{ $topic->name }}</h1>
        
        @if($topic->description)
            <p class="text-gray-600 dark:text-gray-300 mt-2">{{ $topic->description }}</p>
        @endif
        
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-3">
            {{ $topic->groups->count() }} {{ Str::plural('Group', $topic->groups->count()) }}
        </p>
    </div>

    {{-- Groups List --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @forelse($topic->groups as $group)
        <a href="{{ route('groups.show', $group) }}" 
           class="block p-6 rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-md hover:shadow-lg transition">
            
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $group->name }}</h2>
            
            <p class="text-gray-600 dark:text-gray-300 mt-2">
                {{ $group->description ?? 'No description.' }}
            </p>
            
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-3">
                Members: <span class="font-medium text-gray-900 dark:text-gray-100">{{ $group->members->count() }}</span>
            </p>

            <p class="text-gray-500 dark:text-gray-400 text-sm">
                Topics: <span class="font-medium text-gray-900 dark:text-gray-100">{{ $group->topics->pluck('name')->join(', ') }}</span>
            </p>

            @auth
                @if($group->members->contains(auth()->id()))
                <span class="mt-4 inline-block px-3 py-1 rounded-full bg-green-200 dark:bg-green-700/70 text-green-800 dark:text-green-100 font-semibold text-xs">
                    Joined
                </span>
                @endif
            @endauth
        </a>
        @empty
        <p class="text-gray-500 dark:text-gray-400">No groups are using this topic yet.</p>
        @endforelse
    </div>

</div>
@endsection
