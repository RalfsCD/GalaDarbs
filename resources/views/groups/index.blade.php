{{-- ===================================================================
  resources/views/groups/index.blade.php — MOBILE-FIRST (hard-safe @ 320px)
  - All/Mine segmented control:
      • mobile: TRUE 50/50 grid (w-full), comfy hit area
      • desktop: dashboard-style pill switch (top-right in hero)
  - Topic rail inertial-scroll + truncating chips; expanded list wraps
  - Decorative blobs hidden on small to avoid subpixel overflow
  - Aggressive page-scoped overflow guards + tiny-screen clamps
  - Desktop width capped to max-w-7xl to match dashboard/create
=================================================================== --}}

@extends('layouts.app')

@section('content')
@php
    use Illuminate\Support\Str;

    // ---------- Inputs & Flags ----------
    $hasPaginator     = method_exists($groups, 'total');
    $searching        = request()->filled('search');
    $searchTerm       = (string) request('search', '');
    $selectedTopicId  = request()->integer('topic');
    $isMine           = request()->boolean('mine');

    $hasTopics        = isset($topics) && $topics && count($topics) > 0;
    $totalTopicsCount = $hasTopics ? $topics->count() : 0;

    // ---------- Topic ordering (selected pinned first, rest by groups_count desc) ----------
    $selectedTopic = null;
    if ($hasTopics) {
        $topicsSorted = $topics->sortByDesc(fn ($t) => (int) ($t->groups_count ?? 0))->values();
        if ($selectedTopicId) {
            $selectedTopic = $topicsSorted->firstWhere('id', $selectedTopicId);
            if ($selectedTopic) {
                $topicsSorted = collect([$selectedTopic])
                    ->merge($topicsSorted->where('id', '!=', $selectedTopicId))
                    ->values();
            }
        }
        $primaryTopics = $topicsSorted->take(3);
        $moreTopics    = $topicsSorted->slice(3)->values();
    }

    // ---------- Collection preparation (keep paginator intact; local filter for Mine) ----------
    if ($hasPaginator) {
        $collection = $groups->getCollection();
        if ($isMine && auth()->check()) {
            $collection = $collection->filter(fn ($g) => $g->members?->contains(auth()->id()));
        }
        $groupsRender = $collection->values();
    } else {
        $groupsRender = collect($groups);
        if ($isMine && auth()->check()) {
            $groupsRender = $groupsRender->filter(fn ($g) => $g->members?->contains(auth()->id()))->values();
        }
    }

    // ---------- Totals ----------
    $displayTotal = $hasPaginator
        ? ($isMine ? $groupsRender->count() : ($groups->total() ?? $groupsRender->count()))
        : $groupsRender->count();

    $renderCount = $groupsRender->count();
@endphp

{{-- EXACT same container width as create.blade.php + page-scoped overflow guards --}}
<div class="page-mobile max-w-7xl mx-auto px-3 sm:px-6 py-6 sm:py-8 space-y-4 sm:space-y-6">

  {{-- ===== Breadcrumbs ===== --}}
  <nav aria-label="Breadcrumb"
       class="rounded-2xl bg-white/70 dark:bg-gray-900/60 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-sm px-3 sm:px-4 py-2 overflow-hidden">
    <ol class="flex items-center flex-wrap gap-1.5 text-[11px] sm:text-sm text-gray-600 dark:text-gray-300">
      <li>
        <a href="{{ url('/') }}" class="inline-flex items-center gap-1 px-2 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition">
          <span class="font-semibold text-gray-900 dark:text-gray-100">PostPit</span>
        </a>
      </li>
      <li aria-hidden="true" class="text-gray-400">
        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
      </li>
      <li class="text-gray-900 dark:text-gray-100 font-semibold">Groups</li>
    </ol>
  </nav>

  {{-- ===== Hero ===== --}}
  <header
    class="relative overflow-hidden rounded-3xl p-6 sm:p-8
           bg-gradient-to-br from-yellow-50 via-white to-yellow-100
           dark:from-gray-900 dark:via-gray-900/70 dark:to-gray-900
           border border-yellow-200/60 dark:border-gray-800 shadow-2xl">

    {{-- Decorative blobs OFF on small to prevent overflow --}}
    <div class="absolute inset-0 -z-10 pointer-events-none opacity-70">
      <div class="hidden sm:block absolute -right-16 -top-12 h-56 w-56 rounded-full blur-3xl bg-yellow-300/30 dark:bg-yellow-500/20"></div>
      <div class="hidden sm:block absolute -left-20 -bottom-16 h-64 w-64 rounded-full blur-3xl bg-orange-300/25 dark:bg-orange-400/15"></div>
    </div>

    {{-- Dashboard-like: left content + RIGHT toggle --}}
    <div class="relative z-10 flex flex-col md:flex-row md:items-start md:justify-between gap-4">
      {{-- Left --}}
      <div class="max-w-2xl space-y-3 min-w-0">
        <div class="inline-flex items-center gap-2">
          <span class="h-2 w-2 rounded-full bg-yellow-400 shadow-[0_0_20px_theme(colors.yellow.300)] motion-safe:animate-pulse"></span>
          <span class="text-[11px] font-semibold tracking-wide uppercase text-yellow-900/80 dark:text-yellow-100/90">Explore</span>
        </div>

        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-b from-gray-900 to-gray-600 dark:from-white dark:to-gray-300">
          Groups
        </h1>

        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">
          Discover communities by interest. Join one — or start your own.
          @if($searching)
            <span class="block mt-1">Showing results for <span class="font-semibold text-gray-900 dark:text-gray-100">“{{ $searchTerm }}”</span>.</span>
          @endif
        </p>

        @if($displayTotal)
          <div aria-live="polite" class="inline-flex items-center gap-2 text-[11px] sm:text-xs font-semibold text-yellow-900 dark:text-yellow-100 bg-yellow-400/15 dark:bg-yellow-500/20 border border-yellow-300/40 dark:border-yellow-500/40 rounded-full px-3 py-1">
            <span class="h-1.5 w-1.5 rounded-full bg-yellow-400"></span>
            {{ number_format($displayTotal) }} {{ Str::plural('group', $displayTotal) }}
          </div>
        @endif

        {{-- Create button (kept on left) --}}
        <div>
          <a href="{{ route('groups.create') }}"
             class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full bg-yellow-400 text-gray-900 text-sm font-semibold border border-yellow-300/70 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all dark:bg-yellow-500 dark:hover:bg-yellow-400 dark:text-gray-900 focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Create Group
          </a>
        </div>
      </div>

      {{-- Right: All/Mine segmented control (top-right on desktop; full-width 50/50 on mobile) --}}
      <div class="w-full md:w-auto md:self-start md:ml-4">
        <div role="tablist" aria-label="Filter groups"
             class="w-full grid grid-cols-2 md:inline-flex md:w-auto gap-1 md:gap-2 rounded-full bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-1 md:p-1 shadow-sm">
          <a role="tab" aria-selected="{{ $isMine ? 'false' : 'true' }}"
             href="{{ route('groups.index', array_filter(['search' => $searchTerm ?: null, 'topic' => $selectedTopicId ?: null, 'mine' => null])) }}"
             class="w-full md:w-auto h-11 md:h-10 px-4 rounded-full text-[13px] md:text-sm font-semibold text-center flex items-center justify-center whitespace-nowrap transition
                    data-[active=true]:bg-yellow-400 data-[active=true]:text-gray-900
                    data-[active=true]:ring-1 data-[active=true]:ring-yellow-300 data-[active=true]:dark:ring-yellow-500
                    text-gray-700 dark:text-gray-500"
             data-active="{{ $isMine ? 'false' : 'true' }}">
            <span class="truncate">All</span>
          </a>

          <a role="tab" aria-selected="{{ $isMine ? 'true' : 'false' }}"
             href="{{ route('groups.index', array_filter(['search' => $searchTerm ?: null, 'topic' => $selectedTopicId ?: null, 'mine' => 1])) }}"
             class="w-full md:w-auto h-11 md:h-10 px-4 rounded-full text-[13px] md:text-sm font-semibold text-center flex items-center justify-center whitespace-nowrap transition
                    data-[active=true]:bg-yellow-400 data-[active=true]:text-gray-900
                    data-[active=true]:ring-1 data-[active=true]:ring-yellow-300 data-[active=true]:dark:ring-yellow-500
                    text-gray-700 dark:text-gray-500"
             data-active="{{ $isMine ? 'true' : 'false' }}">
            <span class="truncate">Mine</span>
          </a>
        </div>
      </div>
    </div>
  </header>

  {{-- ===== Search + Topics ===== --}}
  <section class="rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-xl overflow-hidden">
    <div class="p-3 sm:p-6 space-y-3">

      {{-- Search --}}
      <form method="GET" action="{{ route('groups.index') }}" class="w-full" role="search" aria-label="Search groups">
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
          <label for="groups-search" class="sr-only">Search groups</label>

          <div class="relative w-full min-w-0">
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px] sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z"/>
              </svg>
            </span>
            <input id="groups-search" type="search" name="search" value="{{ $searchTerm }}"
                   placeholder="Search groups…" autocomplete="off" inputmode="search"
                   class="w-full min-w-0 pl-10 pr-3 sm:pr-36 py-2 rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-950/70 text-[13px] sm:text-base text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600 shadow-sm" />
            @if($selectedTopicId)<input type="hidden" name="topic" value="{{ $selectedTopicId }}">@endif
            @if($isMine)<input type="hidden" name="mine" value="1">@endif

            @if($searching)
              <a href="{{ route('groups.index', array_filter(['topic' => $selectedTopicId ?: null, 'mine' => $isMine ? 1 : null])) }}"
                 class="hidden sm:flex absolute right-2 top-1/2 -translate-y-1/2 items-center gap-1 px-3 py-1.5 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-700 hover:-translate-y-0.5 hover:shadow transition">
                Clear
              </a>
            @endif
          </div>

          {{-- Mobile actions --}}
          <div class="flex gap-2 sm:hidden">
            <button type="submit"
                    class="px-3.5 py-2 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-[13px] font-semibold hover:-translate-y-0.5 hover:shadow transition">
              Search
            </button>
            @if($searching)
              <a href="{{ route('groups.index', array_filter(['topic' => $selectedTopicId ?: null, 'mine' => $isMine ? 1 : null])) }}"
                 class="px-3.5 py-2 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 text-[13px] border border-transparent hover:-translate-y-0.5 hover:shadow transition">
                Clear
              </a>
            @endif
          </div>
        </div>
      </form>

      {{-- Topics rail + expand --}}
      <div class="w-full space-y-2">
        <div class="overflow-hidden">
          <div id="topic-rail"
               class="flex flex-nowrap items-center gap-2 overflow-x-auto no-scrollbar pb-1 px-1 min-w-0"
               style="-webkit-overflow-scrolling:touch; overscroll-behavior-x:contain; scroll-snap-type:x proximity;">
            {{-- All --}}
            <a href="{{ route('groups.index', array_filter(['search' => $searchTerm ?: null, 'mine' => $isMine ? 1 : null])) }}"
               class="chip shrink-0 inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-[12px] sm:text-[13px] font-semibold
                      border transition scroll-snap-align:start
                      {{ $selectedTopicId ? 'bg-white/70 dark:bg-gray-900/60 border-gray-300/70 dark:border-gray-700/70 text-gray-800 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800' : 'bg-yellow-400 text-gray-900 border-yellow-300/70 shadow-sm hover:shadow' }}">
              All
            </a>

            @if($hasTopics)
              @foreach($primaryTopics as $topic)
                <a href="{{ route('groups.index', array_filter(['search' => $searchTerm ?: null, 'mine' => $isMine ? 1 : null, 'topic' => $topic->id])) }}"
                   class="chip shrink-0 inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-[12px] sm:text-[13px] font-semibold border transition scroll-snap-align:start
                          {{ $selectedTopicId === $topic->id ? 'bg-yellow-400 text-gray-900 border-yellow-300/70 shadow-sm hover:shadow' : 'bg-white/70 dark:bg-gray-900/60 text-gray-800 dark:text-gray-200 border-gray-300/70 dark:border-gray-700/70 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                  <span class="inline-flex items-center gap-1">
                    <span class="chip-dot"></span>
                    <span class="truncate max-w-[8rem]">{{ $topic->name }}</span>
                    <span class="chip-count hidden sm:inline opacity-70 text-[11px] font-semibold">• {{ $topic->groups_count }}</span>
                  </span>
                </a>
              @endforeach

              @if($moreTopics->count() > 0)
                <button id="toggleTopics" type="button"
                        class="chip shrink-0 inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-[12px] sm:text-[13px] font-semibold
                               bg-white/70 dark:bg-gray-900/60 text-gray-800 dark:text-gray-200
                               border border-gray-300/70 dark:border-gray-700/70 hover:bg-gray-50 dark:hover:bg-gray-800 transition scroll-snap-align:start"
                        aria-expanded="false" aria-controls="topics-more">
                  <svg class="w-4 h-4 -ml-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                       stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                  <span class="label-long">Show all ({{ $totalTopicsCount }})</span>
                  <span class="label-short hidden">All ({{ $totalTopicsCount }})</span>
                </button>
              @endif

              @if($selectedTopicId)
                <a href="{{ route('groups.index', array_filter(['search' => $searchTerm ?: null, 'mine' => $isMine ? 1 : null])) }}"
                   class="chip shrink-0 inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-[12px] sm:text-[13px] font-semibold
                          bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200
                          border border-gray-200 dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-700 transition scroll-snap-align:start">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -ml-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
                  Clear
                </a>
              @endif
            @endif
          </div>
        </div>

        {{-- Expanded topics (wraps, stays inside) --}}
        @if($hasTopics && $moreTopics->count() > 0)
          <div id="topics-more" class="hidden mt-1.5 flex flex-wrap items-center gap-2">
            @foreach($moreTopics as $topic)
              <a href="{{ route('groups.index', array_filter(['search' => $searchTerm ?: null, 'mine' => $isMine ? 1 : null, 'topic' => $topic->id])) }}"
                 class="chip inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-[12px] sm:text-[13px] font-semibold
                        bg-white/70 dark:bg-gray-900/60 text-gray-800 dark:text-gray-200
                        border border-gray-300/70 dark:border-gray-700/70 hover:bg-gray-50 dark:hover:bg-gray-800 transition
                        {{ $selectedTopicId === $topic->id ? '!bg-yellow-400 !text-gray-900 !border-yellow-300/70 shadow-sm hover:shadow' : '' }}">
                <span class="inline-flex items-center gap-1">
                  <span class="chip-dot"></span>
                  <span class="truncate max-w-[8rem]">{{ $topic->name }}</span>
                  <span class="chip-count hidden sm:inline opacity-70 text-[11px] font-semibold">• {{ $topic->groups_count }}</span>
                </span>
              </a>
            @endforeach
          </div>
        @endif
      </div>
    </div>
  </section>

  {{-- ===== Groups grid ===== --}}
  <section>
    <div id="groups-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
      @forelse($groupsRender as $group)
        <a href="{{ route('groups.show', $group) }}"
           class="group block w-full p-4 sm:p-6 rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-[0_16px_40px_-20px_rgba(0,0,0,0.30)] hover:shadow-[0_30px_70px_-30px_rgba(0,0,0,0.55)] hover:-translate-y-0.5 transition-all {{ $loop->iteration > 4 ? 'hidden group-card-more' : '' }}">
          <div class="flex items-start justify-between gap-2 min-w-0">
            <h2 class="text-[15px] sm:text-xl text-gray-900 dark:text-gray-100 font-bold break-words min-w-0">
              {{ $group->name }}
            </h2>

            <div class="flex items-center gap-1.5 shrink-0 flex-wrap justify-end">
              <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold
                           bg-yellow-100/80 dark:bg-yellow-500/20 text-yellow-800 dark:text-yellow-100
                           border border-yellow-300/60 dark:border-yellow-500/30">
                <span class="h-1.5 w-1.5 rounded-full bg-yellow-400"></span>
                {{ $group->members->count() }} {{ Str::plural('Member', $group->members->count()) }}
              </span>

              @auth
                @if($group->members->contains(auth()->id()))
                  <span class="inline-flex items-center px-2 py-1 rounded-full text-[11px] font-semibold
                               bg-green-100/80 dark:bg-green-500/20 text-green-800 dark:text-green-100
                               border border-green-300/60 dark:border-green-500/30">
                    Joined
                  </span>
                @endif
              @endauth
            </div>
          </div>

          <p class="text-[13px] sm:text-base text-gray-600 dark:text-gray-300 mt-2 line-clamp-2">
            {{ $group->description ?? 'No description.' }}
          </p>

          @php
            $groupTopics = $group->topics ?? collect();
            $firstThree  = $groupTopics->take(3);
            $extraCount  = max(0, $groupTopics->count() - 3);
          @endphp

          @if($groupTopics->count() > 0)
            <div class="mt-3 flex flex-wrap gap-1.5">
              @foreach($firstThree as $t)
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium
                             bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200
                             border border-gray-200 dark:border-gray-700">
                  <span class="h-1.5 w-1.5 rounded-full bg-yellow-400 mr-1"></span>
                  {{ $t->name }}
                </span>
              @endforeach
              @if($extraCount > 0)
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold
                             bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200
                             border border-gray-200 dark:border-gray-700">
                  +{{ $extraCount }} more
                </span>
              @endif
            </div>
          @endif

          <div class="mt-4 flex items-center justify-between text-[11px] sm:text-xs text-gray-500 dark:text-gray-400">
            <span class="inline-flex items-center gap-1 opacity-90 group-hover:opacity-100 transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12l-7.5 7.5M21 12H3"/>
              </svg>
              View Group
            </span>
          </div>
        </a>
      @empty
        <div class="col-span-full">
          <div class="p-8 sm:p-10 text-center rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-xl">
            <p class="text-gray-600 dark:text-gray-400">{{ $isMine ? "You haven’t joined any groups yet." : ($searching || $selectedTopicId ? "No groups match your filters." : "No groups yet.") }}</p>
            <a href="{{ $isMine ? route('groups.index') : route('groups.create') }}"
               class="inline-flex items-center gap-1.5 mt-4 px-3.5 py-2 rounded-full
                      {{ $isMine ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-200 dark:border-gray-700' : 'bg-yellow-400 text-gray-900 border border-yellow-300/70 dark:bg-yellow-500' }}
                      hover:-translate-y-0.5 hover:shadow transition">
              @unless($isMine)
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
              @endunless
              {{ $isMine ? 'Browse all groups' : 'Create the first group' }}
            </a>
          </div>
        </div>
      @endforelse
    </div>

    @if($renderCount > 4)
      <div class="flex items-center justify-center mt-3 sm:mt-4">
        <button id="toggle-grid-more"
                class="inline-flex items-center h-9 px-4 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 text-xs sm:text-sm font-semibold border border-gray-200 dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-700 transition"
                data-expanded="false" aria-expanded="false" aria-controls="groups-grid">
          Show all
        </button>
      </div>
    @endif
  </section>

  {{-- ===== Pagination ===== --}}
  @if($hasPaginator && $groups->hasPages())
    <div class="pt-1 sm:pt-2 overflow-x-auto no-scrollbar">
      {{ $groups->appends(array_filter([
          'search' => $searchTerm ?: null,
          'topic'  => $selectedTopicId ?: null,
          'mine'   => $isMine ? 1 : null,
      ]))->links() }}
    </div>
  @endif
</div>

{{-- ===== JS (tiny, progressive) ===== --}}
<script>
  // Topics expand/collapse (toggle label + aria)
  (function () {
    const btn = document.getElementById('toggleTopics');
    const wrap = document.getElementById('topics-more');
    if (!btn || !wrap) return;

    const long = btn.querySelector('.label-long');
    const short = btn.querySelector('.label-short');

    btn.addEventListener('click', () => {
      const expanded = btn.getAttribute('aria-expanded') === 'true';
      wrap.classList.toggle('hidden', expanded);
      btn.setAttribute('aria-expanded', expanded ? 'false' : 'true');

      if (long && short) {
        if (expanded) {
          long.textContent = 'Show all ({{ $totalTopicsCount }})';
          short.textContent = 'All ({{ $totalTopicsCount }})';
        } else {
          long.textContent = 'Show less';
          short.textContent = 'Less';
        }
      }
    }, { passive: true });
  })();

  // Show all / Show less for groups grid
  (function () {
    const btn = document.getElementById('toggle-grid-more');
    if (!btn) return;
    const hiddenCards = document.querySelectorAll('.group-card-more');
    const setState = (expanded) => {
      hiddenCards.forEach(el => el.classList.toggle('hidden', !expanded));
      btn.setAttribute('data-expanded', expanded ? 'true' : 'false');
      btn.setAttribute('aria-expanded', expanded ? 'true' : 'false');
      btn.textContent = expanded ? 'Show less' : 'Show all';
    };
    btn.addEventListener('click', () => setState(btn.getAttribute('data-expanded') !== 'true'), { passive: true });
  })();
</script>

{{-- ===== Page-scoped overflow & tiny-screen clamps ===== --}}
<style>
  /* Prevent horizontal scrolling globally */
  html, body { max-width: 100%; overflow-x: hidden; }

  .page-mobile{
    /* desktop width comes from max-w-7xl on the same element */
    width: 100%;
    /* safe-area padding on tiny devices */
    padding-left: max(0.5rem, env(safe-area-inset-left));
    padding-right: max(0.5rem, env(safe-area-inset-right));
    overflow-x: hidden; position: relative;
    container-type: inline-size; /* enable container queries if needed */
  }

  /* ABSOLUTE CLAMP: keep children from overflowing sideways */
  .page-mobile *{
    box-sizing: border-box;
    min-width: 0;
    max-width: 100%;
  }
  .page-mobile img, .page-mobile svg{ max-width:100%; height:auto; }

  /* Hide chip rail scrollbars but keep momentum */
  .no-scrollbar::-webkit-scrollbar{ display:none; }
  .no-scrollbar{ -ms-overflow-style:none; scrollbar-width:none; }

  /* Chip cosmetics + truncation */
  .chip-dot{ width:.4rem; height:.4rem; border-radius:9999px; background:#facc15; display:inline-block; }
  .chip span.truncate{ display:inline-block; vertical-align:bottom; max-width:8rem; }
  #topic-rail{ scroll-padding-left:.5rem; }

  /* Respect reduced motion */
  @media (prefers-reduced-motion: reduce){
    *{ animation: none !important; transition: none !important; scroll-behavior: auto !important; }
  }

  /* Tighter controls for ≤550px */
  @media (max-width:550px){
    header.relative{ padding:12px !important; }
    .chip{ padding:6px 10px !important; font-size:12.5px !important; }
    .chip-count{ display:none !important; }
    #groups-grid a.group{ padding:12px !important; border-radius:18px !important; }
    #groups-grid h2{ font-size:14.5px !important; line-height:1.25 !important; word-break:break-word; overflow-wrap:anywhere; }
    #groups-search{ padding-top:9px !important; padding-bottom:9px !important; }
  }

  /* Ultra-narrow (≤360px) extra clamps */
  @media (max-width:360px){
    .label-long{ display:none !important; }
    .label-short{ display:inline !important; }
    .chip{ padding-inline:6px !important; font-size:12px !important; }
    header.relative{ border-radius:18px !important; }
  }
</style>
@endsection
