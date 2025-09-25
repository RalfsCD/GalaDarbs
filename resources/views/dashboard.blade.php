@extends('layouts.app')

@section('content')
<div id="dashboard-root"
     class="flex flex-col md:flex-row gap-6 md:gap-8 
            bg-gradient-to-br from-gray-50 via-white to-gray-100 
            dark:from-gray-900 dark:via-gray-950 dark:to-black
            fixed inset-0 ml-64 overflow-hidden h-screen"> <!-- Added h-screen to root -->

    <!-- Feed Section -->
    <main id="feed-column"
          class="flex-1 px-4 sm:px-6 md:px-8 py-6 md:py-8 overflow-y-auto scrollbar-hide flex justify-center h-full"> <!-- Feed scrollable with h-full -->

        <div class="w-full max-w-7xl"> <!-- Centered and fixed width for content -->

            <h1 class="text-3xl sm:text-4xl font-extrabold 
                       text-gray-900 dark:text-gray-100 mb-8 tracking-tight">
                Newest Posts
            </h1>

            <!-- Posts container -->
            <div id="posts-container" class="space-y-8">
                @include('partials.post-card-list', ['posts' => $posts])
            </div>

            <!-- Loading spinner -->
            <div id="loading" class="hidden text-center py-6 text-gray-500">
                Loading more posts...
            </div>

            <!-- Sentinel element for infinite scroll -->
            <div id="infinite-scroll-trigger"></div>
        </div>
    </main>

    <!-- Sidebar Section (Groups Sidebar) -->
    <aside id="groups-column"
           class="w-full md:w-80 lg:w-96 px-6 py-8 space-y-6 border-t md:border-t-0 md:border-l border-gray-200 dark:border-gray-700 overflow-y-auto max-h-screen"> <!-- Sidebar scrollable with max-h-screen -->

        <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-gray-100 tracking-tight">
            Your Groups
        </h1>

        @forelse($joinedGroups as $group)
            <a href="{{ route('groups.show', $group) }}" class="block no-underline group">
                <div class="p-5 sm:p-6 rounded-2xl 
                            bg-white dark:bg-gray-800 backdrop-blur-sm 
                            border border-gray-200 dark:border-gray-700
                            shadow-sm hover:shadow-md transition">

                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                        {{ $group->name }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mt-1 text-sm">
                        {{ $group->description ?? 'No description.' }}
                    </p>
                    <p class="text-xs sm:text-sm text-gray-700 dark:text-gray-300 mt-2">
                        Topics: <span class="font-medium">{{ $group->topics->pluck('name')->join(', ') }}</span>
                    </p>

                    @if($group->members->contains(auth()->id()))
                        <span
                            class="mt-4 inline-block px-4 py-1.5 rounded-full bg-green-200/80 dark:bg-green-700/70 text-green-900 dark:text-green-100 font-semibold text-xs sm:text-sm">
                            Joined
                        </span>
                    @endif
                </div>
            </a>
        @empty
            <p class="text-gray-500 dark:text-gray-400 italic">You haven’t joined any groups yet.</p>
        @endforelse
    </aside>
</div> <!-- End of flex container -->

<!-- Comment Drawer -->
<div id="commentDrawer" class="fixed inset-0 hidden bg-black/40 dark:bg-black/70 z-50 justify-end">
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
    let page = 2; // page 1 already loaded
    const trigger = document.getElementById("infinite-scroll-trigger");
    const postsContainer = document.getElementById("posts-container");
    const loading = document.getElementById("loading");

    const observer = new IntersectionObserver(async entries => {
        if (entries[0].isIntersecting) {
            loading.classList.remove("hidden");
            try {
                const res = await fetch(`{{ route('dashboard') }}?page=${page}`, {
                    headers: { "X-Requested-With": "XMLHttpRequest" }
                });
                if (res.ok) {
                    const html = await res.text();
                    if (html.trim().length > 0) {
                        postsContainer.insertAdjacentHTML("beforeend", html);
                        page++;
                    } else {
                        observer.unobserve(trigger); // no more pages
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
