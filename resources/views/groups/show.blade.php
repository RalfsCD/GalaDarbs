@extends('layouts.app')

@section('content')
<div class="ml-64 max-w-5xl px-6 py-8 space-y-8"> {{-- Offset for sidebar --}}

    {{-- Group Info --}}
    <div class="p-6 rounded-3xl 
                bg-white/80 dark:bg-gray-800/70 backdrop-blur-xl 
                border border-gray-200 dark:border-gray-700 shadow-md space-y-4">

        <div class="flex justify-between items-start">
            <div class="space-y-1">
                <h1 class="text-4xl font-extrabold text-gray-900 dark:text-gray-100">{{ $group->name }}</h1>
                <p class="text-gray-600 dark:text-gray-300">{{ $group->description }}</p>
                <p class="text-gray-500 text-sm">Members: {{ $group->members->count() }}</p>
            </div>

            {{-- Delete button --}}
            @auth
            @if(auth()->id() === $group->creator_id || auth()->user()->isAdmin())
            <form action="{{ route('groups.destroy', $group) }}" method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this group?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-red-100 dark:hover:bg-red-900 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 
                                 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 
                                 1-2.244 2.077H8.084a2.25 2.25 0 0 
                                 1-2.244-2.077L4.772 5.79m14.456 
                                 0a48.108 48.108 0 0 
                                 0-3.478-.397m-12 .562c.34-.059.68-.114 
                                 1.022-.165m0 0a48.11 48.11 0 0 
                                 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 
                                 51.964 0 0 0-3.32 0c-1.18.037-2.09 
                                 1.022-2.09 2.201v.916m7.5 0a48.667 
                                 48.667 0 0 0-7.5 0" />
                    </svg>
                </button>
            </form>
            @endif
            @endauth
        </div>

        {{-- Join / Leave --}}
        @auth
        <div class="flex gap-2 mt-2">
            @if($group->members->contains(auth()->id()))
            <form action="{{ route('groups.leave', $group) }}" method="POST">
                @csrf
                <button type="submit"
                        class="px-4 py-2 rounded-full border bg-green-200/80 text-green-900 font-bold hover:bg-green-300 transition">
                    ✅ Joined
                </button>
            </form>
            @else
            <form action="{{ route('groups.join', $group) }}" method="POST">
                @csrf
                <button type="submit"
                        class="px-4 py-2 rounded-full border bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 font-bold hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                    Join
                </button>
            </form>
            @endif
        </div>
        @endauth
    </div>

    {{-- Create post & sorting --}}
    <div class="p-6 rounded-3xl 
                bg-white/80 dark:bg-gray-800/70 backdrop-blur-xl 
                border border-gray-200 dark:border-gray-700 shadow-md 
                flex flex-col sm:flex-row justify-between gap-4">
        <a href="{{ route('posts.create', $group) }}"
           class="inline-flex items-center px-4 py-2 rounded-full border bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 font-bold hover:bg-gray-300 dark:hover:bg-gray-600 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Create Post
        </a>

        <form method="GET" action="{{ route('groups.show', $group) }}">
            <select name="sort" onchange="this.form.submit()"
                    class="px-4 py-2 rounded-full border bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 font-bold cursor-pointer">
                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest</option>
                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest</option>
                <option value="most_liked" {{ request('sort') === 'most_liked' ? 'selected' : '' }}>Most Liked</option>
            </select>
        </form>
    </div>

    {{-- Posts --}}
    <div id="posts-container" class="space-y-6">
        @include('partials.post-card-list', ['posts' => $posts])
    </div>

    <!-- Loading spinner -->
    <div id="loading" class="hidden text-center py-6 text-gray-500">
        Loading more posts...
    </div>

    <!-- Sentinel element -->
    <div id="infinite-scroll-trigger"></div>
</div>

<!-- Comment Drawer -->
<div id="commentDrawer"
     class="fixed inset-0 hidden bg-black/40 dark:bg-black/70 z-50 justify-end">
    <div class="bg-white dark:bg-gray-900 w-full sm:w-[480px] h-full shadow-2xl flex flex-col">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h2 class="text-lg font-bold">Comments</h2>
            <button id="closeComments" class="text-gray-500 hover:text-gray-800 dark:hover:text-gray-200">&times;</button>
        </div>
        <div id="commentsList" class="flex-1 overflow-y-auto p-4 space-y-3"></div>
        <form id="commentForm" class="p-4 border-t border-gray-200 dark:border-gray-700 flex gap-2">
            @csrf
            <input type="hidden" name="post_id" id="commentPostId">
            <input name="content" placeholder="Write a comment..."
                   class="flex-1 rounded-full p-2 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring focus:ring-yellow-300 dark:focus:ring-yellow-600">
            <button class="px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-white rounded-full">Send</button>
        </form>
    </div>
</div>

<!-- Image Lightbox -->
<div id="imageModal" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50">
    <span id="closeImageModal" class="absolute top-6 right-8 text-white text-4xl cursor-pointer">&times;</span>
    <img id="modalImage" src="" class="max-h-[90%] max-w-[90%] rounded-xl shadow-2xl">
</div>
@endsection

@section('scripts')
@include('partials.post-scripts')

<script>
document.addEventListener("DOMContentLoaded", () => {
    let page = 2; // page 1 is already loaded
    const trigger = document.getElementById("infinite-scroll-trigger");
    const postsContainer = document.getElementById("posts-container");
    const loading = document.getElementById("loading");

    const observer = new IntersectionObserver(async entries => {
        if (entries[0].isIntersecting) {
            loading.classList.remove("hidden");
            try {
                const url = new URL(window.location.href);
                url.searchParams.set('page', page);

                const res = await fetch(url, {
                    headers: { "X-Requested-With": "XMLHttpRequest" }
                });
                if (res.ok) {
                    const html = await res.text();
                    if (html.trim().length > 0) {
                        postsContainer.insertAdjacentHTML("beforeend", html);
                        page++;
                    } else {
                        observer.unobserve(trigger);
                    }
                }
            } catch (err) {
                console.error("Infinite scroll error:", err);
            } finally {
                loading.classList.add("hidden");
            }
        }
    });

    observer.observe(trigger);
});
</script>
@endsection
