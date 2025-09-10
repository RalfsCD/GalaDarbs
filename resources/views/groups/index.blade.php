@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 space-y-6">

    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Groups</h1>
        <a href="{{ route('groups.create') }}" 
           class="px-4 py-2 rounded-full border-2 border-gray-300 bg-gray-200 text-gray-900 font-bold hover:bg-gray-300 transition">
            + Create Group
        </a>
    </div>

    <!-- Search & Filter -->
    <form method="GET" action="{{ route('groups.index') }}" class="flex items-center gap-2 mb-4">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search groups..."
               class="flex-1 px-4 py-2 rounded-full border-2 border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
        <button type="submit"
                class="px-4 py-2 rounded-full border-2 border-gray-300 bg-gray-200 text-gray-900 font-bold hover:bg-gray-300 transition">
            Search
        </button>
    </form>

    <!-- Topic Filter Bubbles -->
    <div class="flex flex-wrap gap-2 mb-4">
        @foreach($topics as $topic)
            <a href="{{ route('groups.index', ['topic' => $topic->id]) }}"
               class="px-4 py-2 rounded-full border-2 border-gray-300 cursor-pointer
                      {{ request('topic') == $topic->id ? 'bg-gray-200 text-gray-900' : 'bg-white text-gray-700' }}
                      hover:bg-gray-100 hover:text-gray-900 transition">
                {{ $topic->name }}
            </a>
        @endforeach

        @if(request('topic'))
            <a href="{{ route('groups.index') }}" 
               class="px-4 py-2 rounded-full border-2 border-red-300 bg-red-200 text-red-800 hover:bg-red-100 transition">
               Clear Filter
            </a>
        @endif
    </div>

    <!-- Groups List -->
    <div class="space-y-4">
        @forelse($groups as $group)
            <div class="p-4 rounded-2xl 
                        bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                        backdrop-blur-md border border-gray-200 shadow-sm hover:shadow-md transition">

                <!-- Card Link -->
                <a href="{{ route('groups.show', $group) }}" class="block space-y-2 no-underline">
                    <h2 class="text-xl font-bold text-gray-900">{{ $group->name }}</h2>
                    <p class="text-gray-600">{{ $group->description }}</p>
                    <p class="text-sm text-gray-500">Created by: {{ $group->creator->name }}</p>
                    <p class="text-sm text-gray-700">Topics: {{ $group->topics->pluck('name')->join(', ') }}</p>
                    <p class="text-sm text-gray-500">Members: {{ $group->members->count() }}</p>
                </a>

                <!-- Join/Leave Buttons -->
                <div class="mt-3 flex gap-2">
                    @if($group->members->contains(auth()->id()))
                        <form action="{{ route('groups.leave', $group) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to leave this group?');">
                            @csrf
                            <button type="submit"
                                    class="px-4 py-2 rounded-full border-2 border-gray-300 bg-white text-gray-700 font-bold hover:bg-gray-100 transition">
                                Joined
                            </button>
                        </form>
                    @else
                        <form action="{{ route('groups.join', $group) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="px-4 py-2 rounded-full border-2 border-gray-300 bg-gray-200 text-gray-900 font-bold hover:bg-gray-300 transition">
                                Join
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-500">No groups yet. Be the first to create one!</p>
        @endforelse
    </div>
</div>
@endsection
