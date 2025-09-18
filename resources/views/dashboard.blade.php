@extends('layouts.app')

@section('content')
{{-- Dashboard root: fixed under the navbar. JS will set exact top based on the real navbar height. --}}
<div id="dashboard-root"
     class="bg-gray-100"
     style="position:fixed; top:64px; left:0; right:0; bottom:0; display:flex; gap:1.5rem; box-sizing:border-box; overflow:hidden;">

    <!-- Feed Section (scrollable) -->
    <main id="feed-column" class="flex-1 px-6 py-6 space-y-6 scrollbar-hide" style="height:100%; overflow-y:auto;">
                    <h1 class="text-4xl font-extrabold text-gray-900">Newest Posts</h1>

        @forelse($posts as $post)
            <a href="{{ route('posts.show', $post) }}" class="block no-underline">
                <div class="p-4 rounded-2xl bg-white/30 backdrop-blur-md border border-gray-200 
                            shadow-sm hover:shadow-md hover:scale-[1.01] transition-transform duration-200 overflow-hidden">
                    
                    {{-- User info with profile picture OR initials --}}
                    <div class="flex justify-between items-center mb-2">
                        <div class="flex items-center gap-2">
                            @if($post->user->profile_photo_path)
                                <img src="{{ asset('storage/' . $post->user->profile_photo_path) }}" 
                                     alt="{{ $post->user->name }}" 
                                     class="w-8 h-8 rounded-full object-cover shadow-sm">
                            @else
                                <div class="w-8 h-8 rounded-full bg-gray-400 flex items-center justify-center text-white font-bold text-xs shadow-sm">
                                    {{ strtoupper(substr($post->user->name, 0, 2)) }}
                                </div>
                            @endif

                            <div>
                                <p class="font-bold text-gray-900">{{ $post->user->name }}</p>
                                <p class="text-sm">
                                    in 
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded-full font-medium">
                                        {{ $post->group->name }}
                                    </span>
                                </p>
                            </div>
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
                            <img src="{{ $liked ? asset('icons/liked.svg') : asset('icons/like.svg') }}" 
                                 alt="Like" 
                                 class="w-5 h-5">
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
            <h1 class="text-4xl font-extrabold text-gray-900">Your Groups</h1>

        @forelse($joinedGroups as $group)
            <a href="{{ route('groups.show', $group) }}" class="block no-underline">
                <div class="p-4 rounded-2xl bg-white/30 backdrop-blur-md border border-gray-200 
                            shadow-sm hover:shadow-md hover:scale-[1.01] transition-transform duration-200">
                    <h3 class="text-xl font-bold text-gray-900">
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded-full">
                            {{ $group->name }}
                        </span>
                    </h3>
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
    const nav = document.querySelector('nav');
    const dashboardRoot = document.getElementById('dashboard-root');
    const feedCol = document.getElementById('feed-column');
    const groupsCol = document.getElementById('groups-column');

    function applyLayout() {
        const navHeight = (nav && nav.offsetHeight) ? nav.offsetHeight : 0;
        dashboardRoot.style.top = navHeight + 'px';
        dashboardRoot.style.bottom = '0';
        dashboardRoot.style.left = '0';
        dashboardRoot.style.right = '0';
        dashboardRoot.style.position = 'fixed';
        dashboardRoot.style.display = 'flex';
        dashboardRoot.style.gap = '1.5rem';
        dashboardRoot.style.boxSizing = 'border-box';
        dashboardRoot.style.overflow = 'hidden';
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
    window.addEventListener('resize', applyLayout);

    const prevHtmlOverflow = document.documentElement.style.overflow || '';
    const prevBodyOverflow = document.body.style.overflow || '';
    document.documentElement.style.overflow = 'hidden';
    document.body.style.overflow = 'hidden';

    document.querySelectorAll('a').forEach(a => {
        a.addEventListener('click', (e) => {
            if (!e.metaKey && !e.ctrlKey && !e.shiftKey && !e.altKey) {
                document.documentElement.style.overflow = prevHtmlOverflow;
                document.body.style.overflow = prevBodyOverflow;
            }
        });
    });

    window.addEventListener('beforeunload', function () {
        document.documentElement.style.overflow = prevHtmlOverflow;
        document.body.style.overflow = prevBodyOverflow;
    });
});
</script>
@endsection
