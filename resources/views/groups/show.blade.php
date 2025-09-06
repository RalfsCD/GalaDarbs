@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 space-y-6">
    <h1 class="text-3xl font-bold text-yellow-400">{{ $group->name }}</h1>
    <p class="text-gray-300">{{ $group->description }}</p>
    <p class="text-sm text-gray-400">Created by: {{ $group->creator->name }}</p>
    <p class="text-sm text-yellow-400">Topics: {{ $group->topics->pluck('name')->join(', ') }}</p>
    <p class="text-sm text-gray-300">Members: {{ $group->members->count() }}</p>

    <!-- Join / Leave Button -->
    @if($group->members->contains(auth()->id()))
        <form action="{{ route('groups.leave', $group) }}" method="POST">
            @csrf
            <button class="bg-red-500 px-4 py-2 text-white rounded mt-4">Leave Group</button>
        </form>
    @else
        <form action="{{ route('groups.join', $group) }}" method="POST">
            @csrf
            <button class="bg-green-500 px-4 py-2 text-white rounded mt-4">Join Group</button>
        </form>
    @endif

    <!-- List of members -->
    <div class="mt-6">
        <h2 class="text-xl font-bold text-yellow-400 mb-2">Members</h2>
        <ul class="list-disc list-inside text-gray-300">
            @foreach($group->members as $member)
                <li>{{ $member->name }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
