@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 space-y-6">

    {{-- Page Header --}}
    <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 shadow-md flex items-center justify-between">
        <h1 class="text-4xl font-extrabold text-gray-900 dark:text-gray-100">News</h1>

        {{-- Add News Button for Admin --}}
        @if(auth()->user() && auth()->user()->role === 'admin')
        <a href="{{ route('news.create') }}"
            class="px-5 py-2.5 rounded-full bg-yellow-500 text-white font-bold border border-yellow-400 shadow-md hover:bg-yellow-600 hover:shadow-lg transition flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span>Create News</span>
        </a>
        @endif
    </div>

    {{-- News List (Feed View) --}}
    <div class="space-y-8">
     @foreach ($news as $item)
    <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 shadow-md hover:shadow-xl transition">
        <div class="relative">
            
            {{-- News Image --}}
            @if($item->image)
                <img src="{{ Storage::url('news/' . $item->image) }}" 
                     alt="{{ $item->title }}" 
                     class="w-full h-72 object-cover rounded-lg shadow-lg mb-4">
            @endif
            
            {{-- News Title --}}
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100">{{ $item->title }}</h2>
            
            {{-- Content --}}
            <p class="text-gray-600 dark:text-gray-300 mt-4 line-clamp-3">{{ $item->content }}</p>
            
            {{-- Date --}}
            <p class="text-gray-500 text-sm mt-3">Published {{ $item->created_at->diffForHumans() }}</p>

        </div>
    </div>
@endforeach

    </div>

</div>
@endsection
