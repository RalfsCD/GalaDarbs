@extends('layouts.app')

@section('content')
<main class="bg-gray-100 min-h-screen pt-6 px-6">
    <div class="max-w-4xl mx-auto space-y-10">

        <!-- Page Header -->
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">Latest News</h1>

            @if(auth()->user() && auth()->user()->role === 'admin')
                <a href="{{ route('news.create') }}" 
                   class="px-4 py-2 rounded-full border-2 border-gray-300 bg-gray-200 text-gray-900 font-bold hover:bg-gray-300 transition">
                    + Add News
                </a>
            @endif
        </div>

        <!-- News List -->
        <div class="space-y-6">
            @forelse ($news as $item)
                <div class="p-6 rounded-2xl 
                            bg-white/30 backdrop-blur-sm border border-gray-200 shadow-sm hover:shadow-md transition space-y-4">

                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" 
                             alt="{{ $item->title }}" 
                             class="w-full rounded-lg object-contain shadow-sm">
                    @endif

                    <h2 class="text-2xl font-bold text-gray-900">{{ $item->title }}</h2>
                    <p class="text-gray-700 text-lg leading-relaxed">{{ $item->content }}</p>
                    <p class="text-sm text-gray-500">Published {{ $item->created_at->diffForHumans() }}</p>
                </div>
            @empty
                <p class="text-gray-500">No news yet. Be the first to add one!</p>
            @endforelse
        </div>

    </div>
</main>
@endsection
