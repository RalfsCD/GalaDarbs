@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 space-y-6">

    <!-- Tēmas informācija -->
    <div class="p-5 rounded-2xl 
                bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                backdrop-blur-md border border-gray-200 shadow-sm">
        <h1 class="text-3xl font-bold text-gray-900">{{ $topic->name }}</h1>
        @if($topic->description)
        <p class="text-gray-600 mt-1">{{ $topic->description }}</p>
        @endif
        <p class="text-gray-500 mt-2">{{ $topic->groups->count() }} Groups</p>
    </div>

    <!-- Grupu saraksts -->
    <div class="space-y-4">
        @forelse($topic->groups as $group)
        <div class="p-4 rounded-2xl 
                        bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                        backdrop-blur-md border border-gray-200 shadow-sm hover:shadow-md transition">


            <a href="{{ route('groups.show', $group) }}" class="block space-y-2 no-underline">
                <h2 class="text-xl font-bold text-gray-900">{{ $group->name }}</h2>
                <p class="text-gray-600">{{ $group->description ?? 'No description.' }}</p>
                <p class="text-sm text-gray-500">Members: {{ $group->members->count() }}</p>
                <p class="text-sm text-gray-700">
                    Topics: {{ $group->topics->pluck('name')->join(', ') }}
                </p>
            </a>


            @auth
            @if($group->members->contains(auth()->id()))
            <span class="mt-3 inline-block px-3 py-1 rounded-full bg-green-200 text-green-800 font-semibold text-sm">
                Joined
            </span>
            @endif
            @endauth
        </div>
        @empty
        <p class="text-gray-500">No groups are using this topic yet.</p>
        @endforelse
    </div>
</div>
@endsection