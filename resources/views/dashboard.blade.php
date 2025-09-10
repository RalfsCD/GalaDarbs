@extends('layouts.app')

@section('content')
<div class="bg-black text-white min-h-screen p-6 space-y-8">
    <h1 class="text-3xl font-extrabold mb-6">
        Welcome to <span class="inline-block animate-shake text-yellow-400">PostPit</span>
    </h1>

    <div class="space-y-6 max-w-3xl mx-auto">
        @forelse($posts as $post)
            {{-- Link to the group page instead of posts.show --}}
            <a href="{{ route('groups.show', $post->group) }}" class="block group">
                <div class="p-5 bg-gray-900 rounded-2xl shadow-lg border border-gray-700 
                            group-hover:border-yellow-400 group-hover:bg-gray-800 transition">

                    {{-- Header --}}
                    <div class="flex justify-between items-center mb-3">
                        <div>
                            <p class="text-yellow-400 font-bold">{{ $post->user->name }}</p>
                            <p class="text-gray-400 text-sm">in {{ $post->group->name }}</p>
                        </div>
                        <span class="text-gray-500 text-xs">{{ $post->created_at->diffForHumans() }}</span>
                    </div>

                    {{-- Title --}}
                    @if($post->title)
                        <h2 class="text-xl font-bold text-white mb-2 group-hover:text-yellow-300">
                            {{ $post->title }}
                        </h2>
                    @endif

                    {{-- Content preview (first ~200 chars) --}}
                    @if($post->content)
                        <p class="text-gray-300 mb-3">
                            {{ \Illuminate\Support\Str::limit($post->content, 200) }}
                        </p>
                    @endif

                    {{-- Image preview --}}
                    @if($post->media_url)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $post->media_url) }}" 
                                 alt="Post Image" 
                                 class="rounded-lg max-h-64 w-full object-cover shadow-md">
                        </div>
                    @endif

                    {{-- Footer: likes & comments --}}
                    <div class="flex justify-between items-center text-sm text-gray-400 mt-4">
                        <span class="flex items-center gap-1">
                            ❤️ <span>{{ $post->likes->count() }}</span>
                        </span>
                        <span class="flex items-center gap-1">
                            💬 <span>{{ $post->comments->count() }}</span>
                        </span>
                    </div>
                </div>
            </a>
        @empty
            <p class="text-gray-400 text-center">
                No posts yet. Join some groups to see activity here!
            </p>
        @endforelse

        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    </div>
</div>

<style>
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    20% { transform: translateX(-2px); }
    40% { transform: translateX(2px); }
    60% { transform: translateX(-1px); }
    80% { transform: translateX(1px); }
}
.animate-shake { display:inline-block; animation:shake 0.6s ease-in-out infinite; }
</style>
@endsection
