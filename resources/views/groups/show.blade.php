@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 space-y-6">
    <h1 class="text-3xl font-bold text-yellow-400">{{ $group->name }}</h1>
    <p class="text-gray-300">{{ $group->description }}</p>

    <p class="text-gray-400">Topic: <span class="text-white">{{ $group->topic->name }}</span></p>
    <p class="text-gray-400">Created by: <span class="text-white">{{ $group->owner->name }}</span></p>

    <h2 class="text-2xl font-semibold text-white mt-4">Members ({{ $group->users->count() }})</h2>
    <ul class="list-disc pl-6 text-gray-300">
        @foreach($group->users as $user)
            <li>{{ $user->name }}</li>
        @endforeach
    </ul>

    @if(!$group->users->contains(auth()->user()))
        <form method="POST" action="{{ route('groups.join', $group) }}">
            @csrf
            <button type="submit" class="bg-yellow-400 text-black px-4 py-2 rounded hover:bg-yellow-300 mt-4">
                Join Group
            </button>
        </form>
    @else
        <p class="text-green-400 mt-4">You are a member of this group ✅</p>
    @endif
</div>
@endsection
