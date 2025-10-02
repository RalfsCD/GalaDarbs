@extends('layouts.app')

@section('content')
@php
    use Illuminate\Support\Str;

    $hasPaginator = method_exists($posts, 'total');
    $totalPosts   = $hasPaginator ? ($posts->total() ?? $posts->count()) : (is_countable($posts) ? count($posts) : 0);
    $groupsCount  = isset($joinedGroups) && is_countable($joinedGroups) ? $joinedGroups->count() : 0;

    $previewLimit = 3;
    $groupsPreview = $joinedGroups->take($previewLimit);
    $groupsRest    = $joinedGroups->skip($previewLimit);
@endphp

<div class="max-w-7xl mx-auto px-3 sm:px-6 py-6 sm:py-8 space-y-4 sm:space-y-6">

  {{-- ===== Breadcrumbs ===== --}}
  <nav aria-label="Breadcrumb"
       class="rounded-2xl bg-white/70 dark:bg-gray-900/60 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-sm px-3 sm:px-4 py-2">
    <ol class="flex items-center flex-wrap gap-1.5 text-xs sm:text-sm text-gray-600 dark:text-gray-300">
      <li>
        <a href="{{ url('/') }}" class="inline-flex items-center gap-1 px-2 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition">
          <span class="font-semibold text-gray-900 dark:text-gray-100">PostPit</span>
        </a>
      </li>
      <li aria-hidden="true" class="text-gray-400">
        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
      </li>
      <li id="crumb-mode" class="text-gray-900 dark:text-gray-100 font-semibold">Overview</li>
    </ol>
  </nav>

  {{-- ===== Hero (Mode Switch in hero) ===== --}}
  <header
    class="relative overflow-hidden rounded-3xl p-6 sm:p-8
           bg-gradient-to-br from-yellow-50 via-white to-yellow-100
           dark:from-gray-900 dark:via-gray-900/70 dark:to-gray-900
           border border-yellow-200/60 dark:border-gray-800 shadow-2xl">
    <div class="absolute inset-0 -z-10 opacity-70">
      <div class="absolute -top-24 -right-24 h-72 w-72 rounded-full blur-3xl bg-gradient-to-br from-yellow-300/40 to-orange-400/30 dark:from-yellow-500/25 dark:to-orange-400/20"></div>
      <div class="absolute -bottom-28 -left-20 h-80 w-80 rounded-full blur-3xl bg-gradient-to-tr from-white/40 to-yellow-200/40 dark:from-gray-800/40 dark:to-yellow-500/20"></div>
    </div>

    <div class="relative z-10 flex flex-col md:flex-row md:items-start md:justify-between gap-4">
      <div class="max-w-2xl space-y-2">
        <div class="inline-flex items-center gap-2">
          <span class="h-2 w-2 rounded-full bg-yellow-400 shadow-[0_0_20px_theme(colors.yellow.300)] motion-safe:animate-pulse"></span>
          <span class="text-[11px] font-semibold tracking-wide uppercase text-yellow-900/80 dark:text-yellow-100/90">Welcome</span>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-b from-gray-900 to-gray-600 dark:from-white dark:to-gray-300">
          Your PostPit Dashboard
        </h1>
        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">
          Jump into your communities, track what’s new, and discover fresh topics.
        </p>
      </div>

      {{-- Mode Switch (Pills) --}}
      <div class="md:self-start">
        <div class="inline-flex p-1 rounded-full bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm">
          <button id="btn-overview"
                  class="mode-btn data-[active=true]:bg-yellow-400 data-[active=true]:text-gray-900
                         data-[active=true]:ring-1 data-[active=true]:ring-yellow-300 data-[active=true]:dark:ring-yellow-500
                         h-10 px-4 rounded-full text-sm font-semibold text-gray-700 dark:text-gray-500 transition"
                  data-target="overview" data-active="true" aria-pressed="true">Overview</button>
          <button id="btn-feed"
                  class="mode-btn data-[active=true]:bg-yellow-400 data-[active=true]:text-gray-900
                         data-[active=true]:ring-1 data-[active=true]:ring-yellow-300 data-[active=true]:dark:ring-yellow-500
                         h-10 px-4 rounded-full text-sm font-semibold text-gray-700 dark:text-gray-500 transition"
                  data-target="feed" aria-pressed="false">Feed</button>
        </div>
      </div>
    </div>
  </header>

  {{-- ===== Overview ===== --}}
  <section id="view-overview" class="space-y-6 sm:space-y-8">
    {{-- KPI Row --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">

      {{-- KPI: Groups Joined --}}
      <div class="rounded-2xl p-5 h-32 flex flex-col justify-between
                  bg-white/80 dark:bg-gray-900/70 backdrop-blur
                  border border-gray-200/70 dark:border-gray-800/70
                  shadow-[0_12px_32px_-20px_rgba(0,0,0,0.35)]">
        <div class="flex items-center justify-between">
          <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Groups Joined</p>
          <span class="h-2 w-2 rounded-full bg-yellow-400 shadow-[0_0_10px_theme(colors.yellow.300)]"></span>
        </div>
        <div class="flex items-end justify-between">
          <h3 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100">{{ number_format($groupsCount) }}</h3>
          <a href="{{ route('groups.index') }}"
             class="inline-flex items-center h-8 px-3 rounded-full text-xs font-semibold
                    bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700
                    text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition">Manage</a>
        </div>
      </div>

      {{-- KPI: Newest Posts --}}
      <div class="rounded-2xl p-5 h-32 flex flex-col justify-between
                  bg-white/80 dark:bg-gray-900/70 backdrop-blur
                  border border-gray-200/70 dark:border-gray-800/70
                  shadow-[0_12px_32px_-20px_rgba(0,0,0,0.35)]">
        <div class="flex items-center justify-between">
          <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Newest Posts</p>
          <span class="h-2 w-2 rounded-full bg-yellow-400 shadow-[0_0_10px_theme(colors.yellow.300)]"></span>
        </div>
        <div class="flex items-end justify-between">
          <h3 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100">{{ number_format($totalPosts) }}</h3>
          <button data-target="feed"
                  class="mode-link inline-flex items-center h-8 px-3 rounded-full text-xs font-semibold
                         bg-yellow-400/80 border border-yellow-300/70 text-gray-900
                         hover:bg-yellow-500 transition">Open Feed</button>
        </div>
      </div>

      {{-- KPI: Explore Topics --}}
      <div class="rounded-2xl p-5 h-32 flex flex-col justify-between
                  bg-white/80 dark:bg-gray-900/70 backdrop-blur
                  border border-gray-200/70 dark:border-gray-800/70
                  shadow-[0_12px_32px_-20px_rgba(0,0,0,0.35)]">
        <div class="flex items-center justify-between">
          <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Discover</p>
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0z"/>
          </svg>
        </div>
        <div class="flex items-end justify-between">
          <h3 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 leading-tight">
            <span class="block">Explore</span><span class="block">Topics</span>
          </h3>
          <a href="{{ route('topics.index') }}"
             class="inline-flex items-center h-8 px-3 rounded-full text-xs font-semibold
                    bg-yellow-400/80 border border-yellow-300/70 text-gray-900
                    hover:bg-yellow-500 transition">Browse</a>
        </div>
      </div>

      {{-- KPI: Explore Groups --}}
      <div class="rounded-2xl p-5 h-32 flex flex-col justify-between
                  bg-white/80 dark:bg-gray-900/70 backdrop-blur
                  border border-gray-200/70 dark:border-gray-800/70
                  shadow-[0_12px_32px_-20px_rgba(0,0,0,0.35)]">
        <div class="flex items-center justify-between">
          <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Communities</p>
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/>
          </svg>
        </div>
        <div class="flex items-end justify-between">
          <h3 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100 leading-tight">
            <span class="block">Explore</span><span class="block">Groups</span>
          </h3>
          <a href="{{ route('groups.index') }}"
             class="inline-flex items-center h-8 px-3 rounded-full text-xs font-semibold
                    bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700
                    text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition">Browse</a>
        </div>
      </div>
    </div>

    {{-- ===== Your Groups (preview + Show all/less) ===== --}}
    <section class="space-y-3">
      <div class="flex items-center justify-between">
        <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100">Your Groups</h2>

        @if($groupsCount > $previewLimit)
          <button id="toggle-all-groups"
                  class="inline-flex items-center h-9 px-4 rounded-full bg-yellow-400 text-gray-900 text-xs sm:text-sm font-semibold border border-yellow-300/70 shadow-sm hover:shadow-md transition"
                  aria-expanded="false" aria-controls="groups-rest">
            Show all
            <svg class="w-3.5 h-3.5 ml-1 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
          </button>
        @endif
      </div>

      {{-- First 3 --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        @forelse($groupsPreview as $group)
          <a href="{{ route('groups.show', $group) }}" class="group block">
            <div class="p-5 sm:p-6 rounded-2xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition">
              <div class="flex items-start justify-between gap-2">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $group->name }}</h3>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-yellow-400/15 dark:bg-yellow-500/20 text-yellow-900 dark:text-yellow-100 border border-yellow-300/40 dark:border-yellow-500/40">
                  {{ $group->members->count() }} {{ Str::plural('member', $group->members->count()) }}
                </span>
              </div>
              <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 line-clamp-2">{{ $group->description ?? 'No description.' }}</p>
              @if($group->topics && $group->topics->count())
                <div class="mt-3 flex flex-wrap gap-1.5">
                  @foreach($group->topics->take(3) as $topic)
                    <span class="px-2 py-0.5 rounded-full text-[11px] bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">{{ $topic->name }}</span>
                  @endforeach
                </div>
              @endif
            </div>
          </a>
        @empty
          <p class="text-gray-500 dark:text-gray-400 italic">You haven’t joined any groups yet.</p>
        @endforelse
      </div>

      {{-- Remaining (hidden) --}}
      @if($groupsRest->count())
        <div id="groups-rest" class="hidden">
          <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @foreach($groupsRest as $group)
              <a href="{{ route('groups.show', $group) }}" class="group block">
                <div class="p-5 sm:p-6 rounded-2xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition">
                  <div class="flex items-start justify-between gap-2">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $group->name }}</h3>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-yellow-400/15 dark:bg-yellow-500/20 text-yellow-900 dark:text-yellow-100 border border-yellow-300/40 dark:border-yellow-500/40">
                      {{ $group->members->count() }} {{ Str::plural('member', $group->members->count()) }}
                    </span>
                  </div>
                  <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 line-clamp-2">{{ $group->description ?? 'No description.' }}</p>
                  @if($group->topics && $group->topics->count())
                    <div class="mt-3 flex flex-wrap gap-1.5">
                      @foreach($group->topics->take(3) as $topic)
                        <span class="px-2 py-0.5 rounded-full text-[11px] bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">{{ $topic->name }}</span>
                      @endforeach
                    </div>
                  @endif
                </div>
              </a>
            @endforeach
          </div>

          <div class="flex items-center justify-center mt-4">
            <button id="toggle-less-groups"
                    class="inline-flex items-center h-9 px-4 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 text-xs sm:text-sm font-semibold border border-gray-200 dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-700 transition">
              Show less
            </button>
          </div>
        </div>
      @endif
    </section>
  </section>

  {{-- ===== Feed ===== --}}
  <section id="view-feed" class="hidden">
    <div class="rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-xl p-4 sm:p-6">
      <div class="flex items-center justify-between">
        <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 dark:text-gray-100">Newest Posts</h2>
        <div aria-hidden="true"></div>
      </div>

      <div id="posts-container" class="mt-4 space-y-6 sm:space-y-8">
        @include('partials.post-card-list', ['posts' => $posts])
      </div>

      <div id="loading" class="hidden text-center py-6 text-gray-500">Loading more posts...</div>
      <div id="infinite-scroll-trigger" class="h-1 w-full"></div>
    </div>
  </section>
</div>

{{-- ===== Global Image Lightbox (kept) ===== --}}
<div id="imageModal" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50">
  <span id="closeImageModal" class="absolute top-6 right-8 text-white text-4xl cursor-pointer">&times;</span>
  <img id="modalImage" src="" class="max-h-[90%] max-w-[90%] rounded-xl shadow-2xl" alt="Preview">
</div>
@endsection

@section('scripts')
@include('partials.post-scripts')

<script>
document.addEventListener("DOMContentLoaded", () => {
  const btns = document.querySelectorAll(".mode-btn");
  const modeLinks = document.querySelectorAll(".mode-link");
  const viewOverview = document.getElementById("view-overview");
  const viewFeed = document.getElementById("view-feed");
  const crumbMode = document.getElementById("crumb-mode");

  // Show all / Show less for "Your Groups"
  const toggleAllBtn = document.getElementById('toggle-all-groups');
  const toggleLessBtn = document.getElementById('toggle-less-groups');
  const groupsRest   = document.getElementById('groups-rest');

  if (toggleAllBtn && groupsRest) {
    toggleAllBtn.addEventListener('click', () => {
      groupsRest.classList.remove('hidden');
      toggleAllBtn.setAttribute('aria-expanded', 'true');
      toggleAllBtn.innerHTML = `Show less
        <svg class="w-3.5 h-3.5 ml-1 -rotate-90 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>`;
      toggleAllBtn.addEventListener('click', collapseRest, { once: true });
    });
  }
  if (toggleLessBtn && groupsRest) toggleLessBtn.addEventListener('click', collapseRest);

  function collapseRest() {
    groupsRest.classList.add('hidden');
    if (toggleAllBtn) {
      toggleAllBtn.setAttribute('aria-expanded', 'false');
      toggleAllBtn.innerHTML = `Show all
        <svg class="w-3.5 h-3.5 ml-1 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>`;
      toggleAllBtn.addEventListener('click', () => {
        groupsRest.classList.remove('hidden');
        toggleAllBtn.setAttribute('aria-expanded', 'true');
        toggleAllBtn.innerHTML = `Show less
          <svg class="w-3.5 h-3.5 ml-1 -rotate-90 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
          </svg>`;
        toggleAllBtn.addEventListener('click', collapseRest, { once: true });
      }, { once: true });
    }
  }

  // Infinite scroll ON only in Feed
  let page = 2, observer;
  function manageInfiniteScroll(enable) {
    const trigger = document.getElementById("infinite-scroll-trigger");
    const postsContainer = document.getElementById("posts-container");
    const loading = document.getElementById("loading");
    if (!trigger || !postsContainer || !loading) return;

    if (observer) { observer.disconnect(); observer = null; }
    if (!enable) return;

    observer = new IntersectionObserver(async entries => {
      if (entries[0].isIntersecting) {
        loading.classList.remove("hidden");
        try {
          const url = new URL("{{ route('dashboard') }}", window.location.origin);
          url.searchParams.set("page", page);
          const res = await fetch(url.toString(), { headers: { "X-Requested-With": "XMLHttpRequest" } });
          if (res.ok) {
            const html = await res.text();
            if (html.trim().length > 0) { postsContainer.insertAdjacentHTML("beforeend", html); page++; }
            else { observer.unobserve(trigger); }
          }
        } catch(_) { /* noop */ } finally { loading.classList.add("hidden"); }
      }
    });
    observer.observe(trigger);
  }

  function setMode(target) {
    const isOverview = target === "overview";
    document.querySelectorAll(".mode-btn").forEach(b => {
      const active = (b.dataset.target === target);
      b.dataset.active = active.toString();
      b.setAttribute('aria-pressed', active ? 'true' : 'false');
    });
    viewOverview.classList.toggle("hidden", !isOverview);
    viewFeed.classList.toggle("hidden", isOverview);
    crumbMode.textContent = isOverview ? 'Overview' : 'Feed';
    manageInfiniteScroll(!isOverview);
  }

  document.querySelectorAll(".mode-btn").forEach(b => b.addEventListener("click", () => setMode(b.dataset.target)));
  document.querySelectorAll(".mode-link").forEach(l => l.addEventListener("click", () => setMode(l.dataset.target)));
  setMode("overview");
});
</script>
@endsection
