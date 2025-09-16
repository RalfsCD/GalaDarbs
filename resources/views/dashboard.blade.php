@extends('layouts.app')

@section('content')
{{-- Dashboard root: fixed under the navbar. JS will set exact top based on the real navbar height. --}}
<div id="dashboard-root"
     class="bg-gray-100"
     style="position:fixed; top:64px; left:0; right:0; bottom:0; display:flex; gap:1.5rem; box-sizing:border-box; overflow:hidden;">

    <!-- Feed Section (scrollable) -->
    <main id="feed-column" class="flex-1 px-6 py-6 space-y-6 scrollbar-hide" style="height:100%; overflow-y:auto;">
        <h2 class="text-2xl font-extrabold text-gray-900">Newest Posts</h2>

        @forelse($posts as $post)
            <a href="{{ route('posts.show', $post) }}" class="block no-underline">
                <div class="p-4 rounded-2xl bg-white/30 backdrop-blur-md border border-gray-200 
                            shadow-sm hover:shadow-md hover:scale-[1.01] transition-transform duration-200 overflow-hidden">
                    
                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <p class="font-bold text-gray-900">{{ $post->user->name }}</p>
                            <p class="text-gray-500 text-sm">in {{ $post->group->name }}</p>
                        </div>
                        <span class="text-gray-400 text-xs">{{ $post->created_at->diffForHumans() }}</span>
                    </div>

                    @if($post->title)
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $post->title }}</h3>
                    @endif

                    <p class="text-gray-700 mb-2">{{ $post->content }}</p>

                    @if($post->media_path)
                        <img src="{{ asset('storage/' . $post->media_path) }}" 
                             alt="Post Image" 
                             class="rounded-lg mb-2 max-w-full h-auto shadow-sm">
                    @endif

                    {{-- Likes & Comments --}}
                    <div class="flex items-center gap-4 mt-3">
                        @php
                            $liked = auth()->check() && $post->likes->contains(auth()->id());
                        @endphp
                        <div class="flex items-center gap-1">
                            <img src="{{ $liked ? asset('icons/liked.svg') : asset('icons/like.svg') }}" alt="Like" class="w-5 h-5">
                            <span class="text-gray-900 font-medium">{{ $post->likes_count ?? $post->likes->count() }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <img src="{{ asset('icons/comment.svg') }}" alt="Comment" class="w-5 h-5">
                            <span class="text-gray-900 font-medium">{{ $post->comments_count ?? $post->comments->count() }}</span>
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <p class="text-gray-500">No posts yet. Join some groups to see activity here!</p>
        @endforelse

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </main>

    <!-- Groups Section (scrollable) -->
    <aside id="groups-column" class="w-80 px-6 py-6 space-y-6 border-l border-gray-300 scrollbar-hide" style="height:100%; overflow-y:auto;">
        <h2 class="text-2xl font-extrabold text-gray-900">Your Groups</h2>

        @forelse($joinedGroups as $group)
            <a href="{{ route('groups.show', $group) }}" class="block no-underline">
                <div class="p-4 rounded-2xl bg-white/30 backdrop-blur-md border border-gray-200 
                            shadow-sm hover:shadow-md hover:scale-[1.01] transition-transform duration-200">
                    <h3 class="text-xl font-bold text-gray-900">{{ $group->name }}</h3>
                    <p class="text-gray-600 mt-1">{{ $group->description ?? 'No description.' }}</p>
                    <p class="text-sm text-gray-700 mt-2">
                        Topics: {{ $group->topics->pluck('name')->join(', ') }}
                    </p>

                    @if($group->members->contains(auth()->id()))
                        <span class="mt-3 inline-block px-3 py-1 rounded-full bg-green-200 text-green-800 font-semibold text-sm">
                            Joined
                        </span>
                    @endif
                </div>
            </a>
        @empty
            <p class="text-gray-500">You haven’t joined any groups yet.</p>
        @endforelse
    </aside>
</div>

<style>
/* Hide scrollbars for smooth look */
.scrollbar-hide::-webkit-scrollbar { display: none; }
.scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Find the nav (if present) and compute its height so the dashboard sits below it.
    const nav = document.querySelector('nav');
    const dashboardRoot = document.getElementById('dashboard-root');
    const feedCol = document.getElementById('feed-column');
    const groupsCol = document.getElementById('groups-column');

    function applyLayout() {
        const navHeight = (nav && nav.offsetHeight) ? nav.offsetHeight : 0;
        // Position the dashboard root under the navbar
        dashboardRoot.style.top = navHeight + 'px';
        // Ensure the root fills remaining viewport
        dashboardRoot.style.bottom = '0';
        dashboardRoot.style.left = '0';
        dashboardRoot.style.right = '0';
        dashboardRoot.style.position = 'fixed';
        dashboardRoot.style.display = 'flex';
        dashboardRoot.style.gap = '1.5rem';
        dashboardRoot.style.boxSizing = 'border-box';
        dashboardRoot.style.overflow = 'hidden';
        // Force children height to 100% so their internal scroll works reliably
        if (feedCol) {
            feedCol.style.height = '100%';
            feedCol.style.overflowY = 'auto';
        }
        if (groupsCol) {
            groupsCol.style.height = '100%';
            groupsCol.style.overflowY = 'auto';
        }
    }

    applyLayout();
    // keep correct top on resize (in case navbar height changes on responsive break)
    window.addEventListener('resize', applyLayout);

    // Prevent page scroll by locking html/body overflow; restore when leaving via normal link navigation
    const prevHtmlOverflow = document.documentElement.style.overflow || '';
    const prevBodyOverflow = document.body.style.overflow || '';
    document.documentElement.style.overflow = 'hidden';
    document.body.style.overflow = 'hidden';

    // If user clicks a normal link (not ctrl/cmd/alt/shift), restore overflow so new page behaves normally
    document.querySelectorAll('a').forEach(a => {
        a.addEventListener('click', (e) => {
            if (!e.metaKey && !e.ctrlKey && !e.shiftKey && !e.altKey) {
                document.documentElement.style.overflow = prevHtmlOverflow;
                document.body.style.overflow = prevBodyOverflow;
            }
        });
    });

    // Also restore on beforeunload to be safe
    window.addEventListener('beforeunload', function () {
        document.documentElement.style.overflow = prevHtmlOverflow;
        document.body.style.overflow = prevBodyOverflow;
    });
});
</script>
@endsection
