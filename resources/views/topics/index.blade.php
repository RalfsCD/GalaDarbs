{{-- =============================================================
  resources/views/topics/index.blade.php
  - Tailwind-only
  - NEW: Breadcrumbs (PostPit > Topics)
  - Animated cards, consistent with Groups pages
============================================================= --}}

@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 py-6 sm:py-8 space-y-4 sm:space-y-6">

  @php
    $hasPaginator = method_exists($topics, 'total');
    $totalTopics  = $hasPaginator ? $topics->total() : (is_countable($topics) ? count($topics) : 0);
    $searching    = request()->filled('search');
    $searchTerm   = request('search', '');
  @endphp

  {{-- Breadcrumbs --}}
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
      <li class="text-gray-900 dark:text-gray-100 font-semibold">Topics</li>
    </ol>
  </nav>

  {{-- Header --}}
  <header
    class="relative overflow-hidden rounded-3xl p-6 sm:p-8
           bg-gradient-to-br from-yellow-50 via-white to-yellow-100
           dark:from-gray-900 dark:via-gray-900/70 dark:to-gray-900
           border border-yellow-200/60 dark:border-gray-800 shadow-2xl">
    <div class="absolute inset-0 -z-10">
      <div class="absolute -right-16 -top-10 h-56 w-56 rounded-full blur-3xl bg-yellow-300/30 dark:bg-yellow-500/20"></div>
      <div class="absolute -left-20 -bottom-16 h-64 w-64 rounded-full blur-3xl bg-orange-300/25 dark:bg-orange-400/15"></div>
    </div>

    <div class="relative z-10 flex flex-col gap-5">
      <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">

        <div class="max-w-2xl">
          <div class="inline-flex items-center gap-2 mb-1">
            <span class="h-2 w-2 rounded-full bg-yellow-400 shadow-[0_0_20px_theme(colors.yellow.300)] motion-safe:animate-pulse"></span>
            <span class="text-[11px] font-semibold tracking-wide uppercase text-yellow-900/80 dark:text-yellow-100/90">Explore</span>
          </div>
          <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-b from-gray-900 to-gray-600 dark:from-white dark:to-gray-300">
            Topics
          </h1>

          <p class="mt-2 text-sm sm:text-base text-gray-600 dark:text-gray-400">
            Discover conversations by interest. Follow topics to find groups and posts you’ll enjoy.
            @if($searching)
              <span class="block mt-1">Showing results for <span class="font-semibold text-gray-900 dark:text-gray-100">“{{ $searchTerm }}”</span>.</span>
            @endif
          </p>

          @if($totalTopics)
            <div class="mt-3 inline-flex items-center gap-2 text-[11px] sm:text-xs font-semibold text-yellow-900 dark:text-yellow-100 bg-yellow-400/15 dark:bg-yellow-500/20 border border-yellow-300/40 dark:border-yellow-500/40 rounded-full px-3 py-1">
              <span class="h-1.5 w-1.5 rounded-full bg-yellow-400"></span>
              {{ number_format($totalTopics) }} {{ Str::plural('topic', $totalTopics) }}
            </div>
          @endif
        </div>

        @if(auth()->check() && auth()->user()->isAdmin())
        <div class="flex items-center gap-3 md:self-start">
          <a href="{{ route('topics.create') }}"
             class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full bg-yellow-400 text-gray-900 text-sm font-semibold border border-yellow-300/70 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all dark:bg-yellow-500 dark:hover:bg-yellow-400 dark:text-gray-900 focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Create Topic
          </a>
        </div>
        @endif

      </div>
    </div>
  </header>

  {{-- Search --}}
  <section class="rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-xl">
    <form method="GET" action="{{ route('topics.index') }}" class="p-4 sm:p-6">
      <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
        <label for="topics-search" class="sr-only">Search topics</label>

        <div class="relative w-full min-w-0">
          <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
              <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z"/>
            </svg>
          </span>
          <input id="topics-search" type="search" name="search" value="{{ $searchTerm }}" placeholder="Search topics…" autocomplete="off"
                 class="w-full min-w-0 pl-10 pr-3 sm:pr-36 py-2 rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-950/70 text-sm sm:text-base text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600 shadow-sm" />

          @if($searching)
            <a href="{{ route('topics.index') }}"
               class="hidden sm:flex absolute right-2 top-1/2 -translate-y-1/2 items-center gap-1 px-3 py-1.5 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-700 hover:-translate-y-0.5 hover:shadow transition">
              Clear
            </a>
          @endif
        </div>

        {{-- ADDED: Desktop search submit button with provided SVG --}}
        <button type="submit" title="Search" aria-label="Search"
                class="hidden sm:inline-flex items-center justify-center px-3 py-1.5 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700 hover:-translate-y-0.5 hover:shadow transition">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
          </svg>
        </button>

        <div class="flex gap-2 sm:hidden">
          <button type="submit"
                  class="px-3.5 py-2 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 font-semibold hover:-translate-y-0.5 hover:shadow transition">
            Search
          </button>

          @if($searching)
            <a href="{{ route('topics.index') }}"
               class="px-3.5 py-2 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 border border-transparent hover:-translate-y-0.5 hover:shadow transition">
              Clear
            </a>
          @endif
        </div>
      </div>
    </form>
  </section>

  {{-- Topics grid --}}
  <section>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
      @forelse($topics as $topic)
        <a href="{{ route('topics.show', $topic) }}"
           class="group block p-4 sm:p-6 rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-[0_16px_40px_-20px_rgba(0,0,0,0.30)] hover:shadow-[0_30px_70px_-30px_rgba(0,0,0,0.55)] hover:-translate-y-0.5 transition-all">
          <div class="flex items-start justify-between gap-3">
            <h2 class="text-lg sm:text-xl text-gray-900 dark:text-gray-100 font-bold break-words">
              {{ $topic->name }}
            </h2>
            <span class="shrink-0 inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100/80 dark:bg-yellow-500/20 text-yellow-800 dark:text-yellow-100 border border-yellow-300/60 dark:border-yellow-500/30">
              <span class="h-1.5 w-1.5 rounded-full bg-yellow-400"></span>
              {{ $topic->groups_count }} {{ Str::plural('Group', $topic->groups_count) }}
            </span>
          </div>

          <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300 mt-2 line-clamp-2">
            {{ $topic->description ?? 'No description.' }}
          </p>

          <div class="mt-4 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
            <span class="inline-flex items-center gap-1 opacity-90 group-hover:opacity-100 transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12l-7.5 7.5M21 12H3"/>
              </svg>
              View Topic
            </span>
          </div>
        </a>
      @empty
        <div class="col-span-full">
          @if($searching)
            <div class="p-8 text-center rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-xl">
              <div class="mx-auto mb-3 h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-800 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z"/>
                </svg>
              </div>
              <p class="text-gray-700 dark:text-gray-300">
                No topics match <span class="font-semibold">“{{ $searchTerm }}”</span>.
              </p>
              <a href="{{ route('topics.index') }}"
                 class="inline-flex items-center gap-1.5 mt-4 px-3.5 py-2 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-200 dark:border-gray-700 hover:-translate-y-0.5 hover:shadow transition">
                Clear search
              </a>
            </div>
          @else
            <div class="p-10 text-center rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-xl">
              <p class="text-gray-600 dark:text-gray-400">No topics yet.</p>

              @if(auth()->check() && auth()->user()->isAdmin())
                <a href="{{ route('topics.create') }}"
                   class="inline-flex items-center gap-1.5 mt-4 px-3.5 py-2 rounded-full bg-yellow-400 text-gray-900 border border-yellow-300/70 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition dark:bg-yellow-500 dark:hover:bg-yellow-400">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                  </svg>
                  Create the first topic
                </a>
              @endif
            </div>
          @endif
        </div>
      @endforelse
    </div>
  </section>

  {{-- Pagination --}}
  @if(method_exists($topics, 'hasPages') && $topics->hasPages())
    <div class="pt-2">
      {{ $topics->appends(request()->only('search'))->links() }}
    </div>
  @endif
</div>
@endsection
