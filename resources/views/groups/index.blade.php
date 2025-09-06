@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-yellow-400">Groups</h1>
        <a href="{{ route('groups.create') }}" class="bg-yellow-400 text-black px-4 py-2 rounded font-bold hover:bg-yellow-300">
            + Create Group
        </a>
    </div>

    @forelse($groups as $group)
        <a href="{{ route('groups.show', $group) }}" class="block">
            <div class="p-4 bg-gray-800 rounded-lg space-y-2 hover:bg-gray-700 transition">
                <h2 class="text-xl font-bold text-white">{{ $group->name }}</h2>
                <p class="text-gray-300">{{ $group->description }}</p>
                <p class="text-sm text-gray-400">Created by: {{ $group->creator->name }}</p>
                <p class="text-sm text-yellow-400">Topics: {{ $group->topics->pluck('name')->join(', ') }}</p>
                <p class="text-sm text-gray-300">Members: {{ $group->members->count() }}</p>

                @if($group->members->contains(auth()->id()))
                    <form action="{{ route('groups.leave', $group) }}" method="POST" class="inline-block mt-2">
                        @csrf
                        <button class="bg-red-500 px-3 py-1 text-white rounded">Leave</button>
                    </form>
                @else
                    <form action="{{ route('groups.join', $group) }}" method="POST" class="inline-block mt-2">
                        @csrf
                        <button class="bg-green-500 px-3 py-1 text-white rounded">Join</button>
                    </form>
                @endif
            </div>
        </a>
    @empty
        <p class="text-gray-400">No groups yet. Be the first to create one!</p>
    @endforelse
</div>
@endsection
