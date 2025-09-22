@extends('layouts.app')

@section('content')
<main class="bg-gray-100 min-h-screen pt-6 px-6">
    <div class="max-w-4xl mx-auto space-y-6">

    
        <div class="p-6 rounded-2xl 
                    bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                    backdrop-blur-md border border-gray-200 shadow-sm flex justify-between items-center">
            
            <h1 class="text-4xl font-extrabold text-gray-900">News</h1>

            {{-- Pievienot Ziņas poga priekš Admin --}} 

            @if(auth()->user() && auth()->user()->role === 'admin')
                <a href="{{ route('news.create') }}" 
                   class="inline-flex items-center px-4 py-2 rounded-full border-2 border-gray-300 bg-gray-200 text-gray-900 font-bold hover:bg-gray-300 transition">
                    <img src="{{ asset('icons/add.svg') }}" alt="Add" class="w-5 h-5 mr-2">
                    Add News
                </a>
            @endif
        </div>

        {{-- Ziņu saraksts --}}
        <div class="space-y-6">
            @forelse ($news as $item)
                <div class="p-6 rounded-2xl 
                            bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                            backdrop-blur-md border border-gray-200 shadow-sm hover:shadow-md transition space-y-4">

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
                <div class="p-6 rounded-2xl 
                            bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                            backdrop-blur-md border border-gray-200 shadow-sm text-gray-500">
                    No news yet. Be the first to add one!
                </div>
            @endforelse
        </div>

    </div>
</main>
@endsection
