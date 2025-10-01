{{-- =============================================================
  resources/views/groups/show.blade.php
  - Tailwind-only + plain JS
  - Breadcrumbs (PostPit > Groups > {{ $group->name }})
  - NEW: compact “Back” button to Groups
  - Matches look & feel of groups.index / groups.create
============================================================= --}}

@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 py-6 sm:py-8 space-y-4 sm:space-y-6">

  @php $memberCount = $group->members->count(); @endphp

  {{-- ===== Breadcrumbs ===== --}}
  <nav aria-label="Breadcrumb"
       class="rounded-2xl bg-white/70 dark:bg-gray-900/60 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-sm px-3 sm:px-4 py-2">
    <ol class="flex items-center flex-wrap gap-1.5 text-xs sm:text-sm text-gray-600 dark:text-gray-300">
      <li>
        <a href="{{ url('/') }}"
           class="inline-flex items-center gap-1 px-2 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition">
          <span class="font-semibold text-gray-900 dark:text-gray-100">PostPit</span>
        </a>
      </li>
      <li aria-hidden="true" class="text-gray-400">
        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
      </li>
      <li>
        <a href="{{ route('groups.index') }}"
           class="inline-flex items-center gap-1 px-2 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition">
          <span class="font-semibold">Groups</span>
        </a>
      </li>
      <li aria-hidden="true" class="text-gray-400">
        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
      </li>
      <li class="text-gray-900 dark:text-gray-100 font-semibold truncate max-w-[65vw] sm:max-w-none">
        {{ $group->name }}
      </li>
    </ol>
  </nav>

  {{-- ===== Hero ===== --}}
  <header
    class="relative overflow-hidden rounded-3xl p-6 sm:p-8
           bg-gradient-to-br from-yellow-50 via-white to-yellow-100
           dark:from-gray-900 dark:via-gray-900/70 dark:to-gray-900
           border border-yellow-200/60 dark:border-gray-800 shadow-2xl">
    {{-- ambient beams --}}
    <div class="absolute inset-0 -z-10 opacity-70">
      <div class="absolute -top-24 -right-24 h-72 w-72 rounded-full blur-3xl bg-gradient-to-br from-yellow-300/40 to-orange-400/30 dark:from-yellow-500/25 dark:to-orange-400/20"></div>
      <div class="absolute -bottom-28 -left-20 h-80 w-80 rounded-full blur-3xl bg-gradient-to-tr from-white/40 to-yellow-200/40 dark:from-gray-800/40 dark:to-yellow-500/20"></div>
    </div>

    <div class="relative z-10 flex flex-col md:flex-row md:items-start md:justify-between gap-3 sm:gap-4">
      <div class="max-w-full md:max-w-2xl min-w-0">
        <div class="flex items-center gap-2">
          <span class="inline-block h-2 w-2 rounded-full bg-yellow-400 shadow-[0_0_20px_theme(colors.yellow.300)] motion-safe:animate-pulse"></span>
          <h1 class="text-xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight bg-clip-text text-transparent truncate bg-gradient-to-b from-gray-900 to-gray-600 dark:from-white dark:to-gray-300">
            {{ $group->name }}
          </h1>
        </div>

        <p class="mt-1 sm:mt-2 text-[13px] sm:text-base text-gray-700 dark:text-gray-300 break-words">
          {{ $group->description ?: 'No description provided.' }}
        </p>

        <div class="mt-2 inline-flex items-center gap-2 text-[11px] sm:text-xs font-semibold
                    text-yellow-900 dark:text-yellow-100
                    bg-yellow-400/15 dark:bg-yellow-500/20
                    border border-yellow-300/40 dark:border-yellow-500/40
                    rounded-full px-2.5 sm:px-3 py-0.5">
          <span class="h-1.5 w-1.5 rounded-full bg-yellow-400"></span>
          {{ number_format($memberCount) }} {{ Str::plural('member', $memberCount) }}
        </div>
      </div>

      {{-- Actions --}}
      <div class="flex items-center gap-2 md:self-start">
        {{-- NEW: compact Back button to Groups --}}
        <a href="{{ route('groups.index') }}"
           class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full
                  bg-white/70 dark:bg-gray-900/60 backdrop-blur
                  text-gray-900 dark:text-gray-100 text-sm font-semibold
                  border border-gray-300/70 dark:border-gray-700/80
                  shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all
                  focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600"
           title="Back to Groups">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -ml-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12l7.5-7.5M3 12h18"/>
          </svg>
          Back
        </a>

        @auth
          @if($group->members->contains(auth()->id()))
            <form action="{{ route('groups.leave', $group) }}" method="POST" class="shrink-0">
              @csrf
              <button type="submit"
                      class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full
                             bg-white/70 dark:bg-gray-900/60 backdrop-blur
                             text-gray-900 dark:text-gray-100 text-sm font-semibold
                             border border-gray-300/70 dark:border-gray-700/80
                             shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all
                             focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600"
                      title="Leave group">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                  <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-3A2.25 2.25 0 0 0 8.25 5.25V9M4.5 9h15M6 9v9A2.25 2.25 0 0 0 8.25 20.25h7.5A2.25 2.25 0 0 0 18 18V9"/>
                </svg>
                Joined
              </button>
            </form>
          @else
            <form action="{{ route('groups.join', $group) }}" method="POST" class="shrink-0">
              @csrf
              <button type="submit"
                      class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full
                             bg-yellow-400 text-gray-900 text-sm font-semibold
                             border border-yellow-300/70 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all
                             dark:bg-yellow-500 dark:hover:bg-yellow-400 dark:text-gray-900
                             focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600"
                      title="Join group">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Join
              </button>
            </form>
          @endif
        @endauth

        @auth
        @if(auth()->id() === $group->creator_id || auth()->user()->isAdmin())
          <form action="{{ route('groups.destroy', $group) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this group?');"
                class="shrink-0">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full
                           bg-red-500 hover:bg-red-600 text-white transition shadow-sm hover:shadow-md
                           focus:outline-none focus:ring-2 focus:ring-red-300"
                    title="Delete group">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                   viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor"
                   class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
              </svg>
            </button>
          </form>
        @endif
        @endauth
      </div>
    </div>
  </header>

  {{-- ===== Composer + Sort ===== --}}
  <section class="rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-xl p-3 sm:p-6">
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-2.5 sm:gap-3">

      <a href="{{ route('posts.create', $group) }}"
         class="inline-flex items-center gap-2 px-3.5 py-2 rounded-full
                bg-white/70 dark:bg-gray-900/60 backdrop-blur
                text-gray-900 dark:text-gray-100 text-sm font-semibold
                border border-gray-300/70 dark:border-gray-700/80
                shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 -ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        <span class="whitespace-nowrap">Create Post</span>
      </a>

      <form method="GET" action="{{ route('groups.show', $group) }}" class="sm:ml-auto">
        <label for="sort" class="sr-only">Sort</label>
        <select id="sort" name="sort" onchange="this.form.submit()"
                class="w-full sm:w-auto px-3 py-2 rounded-full
                       bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100
                       text-sm font-medium border border-gray-200 dark:border-gray-700 cursor-pointer">
          <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest</option>
          <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest</option>
          <option value="most_liked" {{ request('sort') === 'most_liked' ? 'selected' : '' }}>Most Liked</option>
        </select>
      </form>
    </div>
  </section>

  {{-- ===== Posts List ===== --}}
  <section>
    <div id="posts-container" class="space-y-6 sm:space-y-8">
      @include('partials.post-card-list', ['posts' => $posts])
    </div>

    <div id="loading" class="hidden text-center py-6 text-gray-500">
      Loading more posts...
    </div>

    <div id="infinite-scroll-trigger" class="h-1 w-full"></div>
  </section>
</div>

{{-- ===== Comment Drawer ===== --}}
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
      <button class="px-4 py-2 rounded-full bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-semibold border border-yellow-300/70 shadow-sm hover:shadow-md transition">
        Send
      </button>
    </form>
  </div>
</div>

{{-- ===== Image Lightbox ===== --}}
<div id="imageModal" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50">
  <span id="closeImageModal" class="absolute top-6 right-8 text-white text-4xl cursor-pointer">&times;</span>
  <img id="modalImage" src="" class="max-h-[90%] max-w-[90%] rounded-xl shadow-2xl" alt="Preview">
</div>
@endsection

@section('scripts')
@include('partials.post-scripts')

<script>
document.addEventListener("DOMContentLoaded", () => {
  // Infinite scroll
  let page = 2; // page 1 already rendered
  const trigger = document.getElementById("infinite-scroll-trigger");
  const postsContainer = document.getElementById("posts-container");
  const loading = document.getElementById("loading");

  const observer = new IntersectionObserver(async entries => {
    if (entries[0].isIntersecting) {
      loading.classList.remove("hidden");
      try {
        const url = new URL(window.location.href);
        url.searchParams.set('page', page);

        const res = await fetch(url, { headers: { "X-Requested-With": "XMLHttpRequest" } });
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
