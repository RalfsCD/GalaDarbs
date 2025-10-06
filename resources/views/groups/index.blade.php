{{-- =============================================================
  resources/views/groups/index.blade.php — Tailwind-only
  - Identical chip structure (ids/classes) to create page
  - “Show all topics (N)” uses the same #topics-more id
  - Selected topic is server-side promoted to first chip
  - NEW: “Clear” bubble appears when a topic filter is active
============================================================= --}}

@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 py-6 sm:py-8 space-y-4 sm:space-y-6">

  @php
      use Illuminate\Support\Str;

      // Base meta
      $hasPaginator      = method_exists($groups, 'total');
      $searching         = request()->filled('search');
      $searchTerm        = request('search', '');
      $selectedTopicId   = request()->integer('topic');
      $isMine            = request()->boolean('mine');
      $selectedTopic     = null;

      // Topics prep (expects ->groups_count via withCount('groups'))
      $hasTopics         = isset($topics) && $topics && count($topics) > 0;
      $totalTopicsCount  = $hasTopics ? $topics->count() : 0;

      if ($hasTopics) {
          $topicsSorted = $topics->sortByDesc(fn ($t) => $t->groups_count ?? 0)->values();

          if ($selectedTopicId) {
              $selectedTopic = $topicsSorted->firstWhere('id', $selectedTopicId);
              if ($selectedTopic) {
                  // Selected topic rendered first (server-side)
                  $topicsSorted = collect([$selectedTopic])
                      ->merge($topicsSorted->where('id', '!=', $selectedTopicId))
                      ->values();
              }
          }

          $primaryTopics    = $topicsSorted->take(3);
          $moreTopics       = $topicsSorted->slice(3)->values();
      }

      // Client-side fallback for ?mine=1 (if controller didn't filter)
      if ($hasPaginator) {
          $collection = $groups->getCollection();
          if ($isMine && auth()->check()) {
              $collection = $collection->filter(fn($g) => $g->members?->contains(auth()->id()));
          }
          $groupsRender = $collection->values();
      } else {
          $groupsRender = collect($groups);
          if ($isMine && auth()->check()) {
              $groupsRender = $groupsRender->filter(fn($g) => $g->members?->contains(auth()->id()))->values();
          }
      }

      $displayTotal = $hasPaginator
          ? ($isMine ? $groupsRender->count() : ($groups->total() ?? $groupsRender->count()))
          : $groupsRender->count();

      // For Show all / Show less
      $renderCount = $groupsRender->count();
  @endphp

  {{-- Breadcrumbs --}}
  <nav aria-label="Breadcrumb"
       class="rounded-2xl bg-white/70 dark:bg-gray-900/60 backdrop-blur
              border border-gray-200/70 dark:border-gray-800/70
              shadow-sm px-3 sm:px-4 py-2">
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
      <li class="text-gray-900 dark:text-gray-100 font-semibold">Groups</li>
    </ol>
  </nav>

  {{-- Header (Create top-right + segmented toggle bottom-right) --}}
  <header
    class="relative overflow-hidden rounded-3xl p-6 sm:p-8
           bg-gradient-to-br from-yellow-50 via-white to-yellow-100
           dark:from-gray-900 dark:via-gray-900/70 dark:to-gray-900
           border border-yellow-200/60 dark:border-gray-800 shadow-2xl">
    <div class="absolute inset-0 -z-10">
      <div class="absolute -right-16 -top-10 h-56 w-56 rounded-full blur-3xl bg-yellow-300/30 dark:bg-yellow-500/20"></div>
      <div class="absolute -left-20 -bottom-16 h-64 w-64 rounded-full blur-3xl bg-orange-300/25 dark:bg-orange-400/15"></div>
    </div>

    {{-- Top-right: Create Group --}}
    <div class="absolute top-4 right-4 sm:top-6 sm:right-6 z-30 pointer-events-auto">
      <a href="{{ route('groups.create') }}"
         class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full bg-yellow-400 text-gray-900 text-sm font-semibold border border-yellow-300/70 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all dark:bg-yellow-500 dark:hover:bg-yellow-400 dark:text-gray-900 focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Create Group
      </a>
    </div>

    <div class="relative z-10 grid gap-4 md:gap-6 md:grid-cols-[1fr,auto]">
      <div class="max-w-2xl">
        <div class="inline-flex items-center gap-2 mb-1">
          <span class="h-2 w-2 rounded-full bg-yellow-400 shadow-[0_0_20px_theme(colors.yellow.300)] motion-safe:animate-pulse"></span>
          <span class="text-[11px] font-semibold tracking-wide uppercase text-yellow-900/80 dark:text-yellow-100/90">Explore</span>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-b from-gray-900 to-gray-600 dark:from-white dark:to-gray-300">
          Groups
        </h1>
        <p class="mt-2 text-sm sm:text-base text-gray-600 dark:text-gray-400">
          Discover communities by interest. Join one — or start your own.
          @if($searching)
            <span class="block mt-1">Showing results for <span class="font-semibold text-gray-900 dark:text-gray-100">“{{ $searchTerm }}”</span>.</span>
          @endif
        </p>

        @if($displayTotal)
          <div class="mt-3 inline-flex items-center gap-2 text-[11px] sm:text-xs font-semibold text-yellow-900 dark:text-yellow-100 bg-yellow-400/15 dark:bg-yellow-500/20 border border-yellow-300/40 dark:border-yellow-500/40 rounded-full px-3 py-1">
            <span class="h-1.5 w-1.5 rounded-full bg-yellow-400"></span>
            {{ number_format($displayTotal) }} {{ Str::plural('group', $displayTotal) }}
          </div>
        @endif
      </div>
    </div>

    {{-- Bottom-right: segmented toggle --}}
    <div class="absolute right-4 bottom-4 sm:right-6 sm:bottom-6 z-40 pointer-events-auto">
      <div class="inline-flex p-1 rounded-full bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm">
        <a href="{{ route('groups.index', array_filter(['search' => $searchTerm ?: null, 'topic' => $selectedTopicId ?: null, 'mine' => null])) }}"
           class="h-10 px-4 rounded-full text-sm font-semibold transition
                  data-[active=true]:bg-yellow-400 data-[active=true]:text-gray-900
                  data-[active=true]:ring-1 data-[active=true]:ring-yellow-300 data-[active=true]:dark:ring-yellow-500
                  text-gray-700 dark:text-gray-500 flex items-center cursor-pointer"
           data-active="{{ $isMine ? 'false' : 'true' }}"
           aria-pressed="{{ $isMine ? 'false' : 'true' }}">
          All groups
        </a>

        <a href="{{ route('groups.index', array_filter(['search' => $searchTerm ?: null, 'topic' => $selectedTopicId ?: null, 'mine' => 1])) }}"
           class="h-10 px-4 rounded-full text-sm font-semibold transition
                  data-[active=true]:bg-yellow-400 data-[active=true]:text-gray-900
                  data-[active=true]:ring-1 data-[active=true]:ring-yellow-300 data-[active=true]:dark:ring-yellow-500
                  text-gray-700 dark:text-gray-500 flex items-center cursor-pointer"
           data-active="{{ $isMine ? 'true' : 'false' }}"
           aria-pressed="{{ $isMine ? 'true' : 'false' }}">
          My groups
        </a>
      </div>
    </div>
  </header>

  {{-- Search + Filter Bubbles --}}
  <section class="rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-xl">
    <div class="p-4 sm:p-6 space-y-3">

      {{-- Search --}}
      <form method="GET" action="{{ route('groups.index') }}" class="w-full">
        <div class="relative w-full">
          <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
              <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z"/>
            </svg>
          </span>
          <input id="groups-search" type="search" name="search" value="{{ $searchTerm }}"
                 placeholder="Search groups…"
                 autocomplete="off"
                 class="w-full min-w-0 pl-10 pr-3 py-2 rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-950/70 text-sm sm:text-base text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600 shadow-sm" />
          @if($selectedTopicId)
            <input type="hidden" name="topic" value="{{ $selectedTopicId }}">
          @endif
          @if($isMine)
            <input type="hidden" name="mine" value="1">
          @endif
        </div>
      </form>

      {{-- Bubbles row (same structure as create) --}}
      <div class="flex flex-wrap items-center gap-2">

        {{-- All bubble --}}
        <a href="{{ route('groups.index', array_filter(['search' => $searchTerm ?: null, 'mine' => $isMine ? 1 : null])) }}"
           class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-sm font-semibold
                  border transition
                  {{ $selectedTopicId ? 'bg-white/70 dark:bg-gray-900/60 border-gray-300/70 dark:border-gray-700/70 text-gray-800 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800' : 'bg-yellow-400 text-gray-900 border-yellow-300/70 shadow-sm hover:shadow' }}">
          All
        </a>

        {{-- Primary topics (selected one is first when present) --}}
        @if($hasTopics)
          <div id="topics-primary" class="flex flex-wrap items-center gap-2">
            @foreach($primaryTopics as $topic)
              <a href="{{ route('groups.index', array_filter(['search' => $searchTerm ?: null, 'mine' => $isMine ? 1 : null, 'topic' => $topic->id])) }}"
                 class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-sm font-semibold
                        border transition
                        {{ $selectedTopicId === $topic->id ? 'bg-yellow-400 text-gray-900 border-yellow-300/70 shadow-sm hover:shadow' : 'bg-white/70 dark:bg-gray-900/60 text-gray-800 dark:text-gray-200 border-gray-300/70 dark:border-gray-700/70 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                <span class="inline-flex items-center gap-1">
                  {{ $topic->name }}
                  <span class="opacity-70 text-xs font-semibold">• {{ $topic->groups_count }}</span>
                </span>
              </a>
            @endforeach

            {{-- Toggle all topics --}}
            @if($moreTopics->count() > 0)
              <button id="toggleTopics" type="button"
                      class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-sm font-semibold
                             bg-white/70 dark:bg-gray-900/60 text-gray-800 dark:text-gray-200
                             border border-gray-300/70 dark:border-gray-700/70
                             hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                <svg class="w-4 h-4 -ml-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="1.8">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Show all topics ({{ $totalTopicsCount }})
              </button>
            @endif

            {{-- NEW: Clear bubble (only when a topic filter is active) --}}
            @if($selectedTopicId)
              <a href="{{ route('groups.index', array_filter(['search' => $searchTerm ?: null, 'mine' => $isMine ? 1 : null])) }}"
                 class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-sm font-semibold
                        bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200
                        border border-gray-200 dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -ml-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                </svg>
                Clear
              </a>
            @endif
          </div>

          {{-- Expanded topics (hidden by default) --}}
          @if($moreTopics->count() > 0)
            <div id="topics-more" class="hidden mt-2 flex flex-wrap items-center gap-2">
              @foreach($moreTopics as $topic)
                <a href="{{ route('groups.index', array_filter(['search' => $searchTerm ?: null, 'mine' => $isMine ? 1 : null, 'topic' => $topic->id])) }}"
                   class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-sm font-semibold
                          bg-white/70 dark:bg-gray-900/60 text-gray-800 dark:text-gray-200
                          border border-gray-300/70 dark:border-gray-700/70
                          hover:bg-gray-50 dark:hover:bg-gray-800 transition
                          {{ $selectedTopicId === $topic->id ? '!bg-yellow-400 !text-gray-900 !border-yellow-300/70 shadow-sm hover:shadow' : '' }}">
                  <span class="inline-flex items-center gap-1">
                    {{ $topic->name }}
                    <span class="opacity-70 text-xs font-semibold">• {{ $topic->groups_count }}</span>
                  </span>
                </a>
              @endforeach
            </div>
          @endif
        @endif
      </div>
    </div>
  </section>

  {{-- Groups grid --}}
  <section>
    <div id="groups-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
      @forelse($groupsRender as $group)
        <a href="{{ route('groups.show', $group) }}"
           class="group block p-4 sm:p-6 rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-[0_16px_40px_-20px_rgba(0,0,0,0.30)] hover:shadow-[0_30px_70px_-30px_rgba(0,0,0,0.55)] hover:-translate-y-0.5 transition-all {{ $loop->iteration > 4 ? 'hidden group-card-more' : '' }}">
          <div class="flex items-start justify-between gap-3">
            <h2 class="text-lg sm:text-xl text-gray-900 dark:text-gray-100 font-bold break-words">
              {{ $group->name }}
            </h2>

            <div class="flex items-center gap-1.5 shrink-0">
              <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold
                           bg-yellow-100/80 dark:bg-yellow-500/20 text-yellow-800 dark:text-yellow-100
                           border border-yellow-300/60 dark:border-yellow-500/30">
                <span class="h-1.5 w-1.5 rounded-full bg-yellow-400"></span>
                {{ $group->members->count() }} {{ Str::plural('Member', $group->members->count()) }}
              </span>

              @auth
                @if($group->members->contains(auth()->id()))
                  <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold
                               bg-green-100/80 dark:bg-green-500/20 text-green-800 dark:text-green-100
                               border border-green-300/60 dark:border-green-500/30">
                    <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                    Joined
                  </span>
                @endif
              @endauth
            </div>
          </div>

          <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300 mt-2 line-clamp-2">
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

          <div class="mt-4 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
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
          @if($isMine)
            <div class="p-10 text-center rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-xl">
              <p class="text-gray-600 dark:text-gray-400">You haven’t joined any groups yet.</p>
              <a href="{{ route('groups.index') }}"
                 class="inline-flex items-center gap-1.5 mt-4 px-3.5 py-2 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-200 dark:border-gray-700 hover:-translate-y-0.5 hover:shadow transition">
                Browse all groups
              </a>
            </div>
          @elseif($searching || $selectedTopicId)
            <div class="p-8 text-center rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-xl">
              <p class="text-gray-700 dark:text-gray-300">
                No groups match your filters.
              </p>
              <a href="{{ route('groups.index') }}"
                 class="inline-flex items-center gap-1.5 mt-4 px-3.5 py-2 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-200 dark:border-gray-700 hover:-translate-y-0.5 hover:shadow transition">
                Clear filters
              </a>
            </div>
          @else
            <div class="p-10 text-center rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-xl">
              <p class="text-gray-600 dark:text-gray-400">No groups yet.</p>
              <a href="{{ route('groups.create') }}"
                 class="inline-flex items-center gap-1.5 mt-4 px-3.5 py-2 rounded-full bg-yellow-400 text-gray-900 border border-yellow-300/70 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition dark:bg-yellow-500 dark:hover:bg-yellow-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Create the first group
              </a>
            </div>
          @endif
        </div>
      @endforelse
    </div>

    {{-- Show all / Show less (only if more than 4 items) --}}
    @if($renderCount > 4)
      <div class="flex items-center justify-center mt-4">
        <button id="toggle-grid-more"
                class="inline-flex items-center h-9 px-4 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 text-xs sm:text-sm font-semibold border border-gray-200 dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-700 transition"
                data-expanded="false" aria-expanded="false" aria-controls="groups-grid">
          Show all
        </button>
      </div>
    @endif
  </section>

  {{-- Pagination (preserves filters) --}}
  @if($hasPaginator && $groups->hasPages())
    <div class="pt-2">
      {{ $groups->appends(array_filter([
          'search' => $searchTerm ?: null,
          'topic'  => $selectedTopicId ?: null,
          'mine'   => $isMine ? 1 : null,
      ]))->links() }}
    </div>
  @endif
</div>

{{-- Tiny JS to toggle “Show all topics” + “Show all groups” --}}
<script>
  // topics expander
  document.getElementById('toggleTopics')?.addEventListener('click', () => {
    const wrap = document.getElementById('topics-more');
    if (!wrap) return;
    wrap.classList.toggle('hidden');
  });

  // groups "Show all / Show less" (first 4 visible)
  (function () {
    const btn = document.getElementById('toggle-grid-more');
    if (!btn) return;
    const hiddenCards = document.querySelectorAll('.group-card-more');
    btn.addEventListener('click', () => {
      const expanded = btn.getAttribute('data-expanded') === 'true';
      hiddenCards.forEach(el => el.classList.toggle('hidden', expanded)); // if expanded -> hide; else show
      btn.setAttribute('data-expanded', expanded ? 'false' : 'true');
      btn.setAttribute('aria-expanded', expanded ? 'false' : 'true');
      btn.textContent = expanded ? 'Show all' : 'Show less';
    });
  })();
</script>
@endsection
