@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 space-y-4">
    <h1 class="text-2xl font-bold text-yellow-400">{{ $post->title ?? 'Post' }}</h1>
    <p class="text-gray-300 mb-2">{{ $post->content }}</p>
    @if($post->image)
        <img src="{{ asset('storage/' . $post->image) }}" class="rounded-lg mb-2">
    @endif
    <p class="text-gray-500 text-sm">Posted by {{ $post->user->name }} in {{ $post->group->name }}</p>
</div>
@endsection