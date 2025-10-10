@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 py-6 sm:py-8 space-y-4 sm:space-y-6">

  @php
    $groupCount = $topic->groups?->count() ?? 0;
  @endphp

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
        <a href="{{ route('topics.index') }}"
           class="inline-flex items-center gap-1 px-2 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition">
          <span class="font-semibold">Topics</span>
        </a>
      </li>
      <li aria-hidden="true" class="text-gray-400">
        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
      </li>
      <li class="text-gray-900 dark:text-gray-100 font-semibold truncate max-w-[65vw] sm:max-w-none">
        {{ $topic->name }}
      </li>
    </ol>
  </nav>

  <header
    class="relative overflow-hidden rounded-3xl p-6 sm:p-8
           bg-gradient-to-br from-yellow-50 via-white to-yellow-100
           dark:from-gray-900 dark:via-gray-900/70 dark:to-gray-900
           border border-yellow-200/60 dark:border-gray-800 shadow-2xl">
    <div class="absolute inset-0 -z-10">
      <div class="absolute -right-16 -top-10 h-56 w-56 rounded-full blur-3xl bg-yellow-300/30 dark:bg-yellow-500/20"></div>
      <div class="absolute -left-20 -bottom-16 h-64 w-64 rounded-full blur-3xl bg-orange-300/25 dark:bg-orange-400/15"></div>
    </div>

    <div class="relative z-10 flex flex-col gap-4">
      <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
        <div class="max-w-3xl">
          <div class="inline-flex items-center gap-2 mb-1">
            <span class="h-2 w-2 rounded-full bg-yellow-400 shadow-[0_0_20px_theme(colors.yellow.300)] motion-safe:animate-pulse"></span>
            <span class="text-[11px] font-semibold tracking-wide uppercase text-yellow-900/80 dark:text-yellow-100/90">Topic</span>
          </div>
          <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-b from-gray-900 to-gray-600 dark:from-white dark:to-gray-300">
            {{ $topic->name }}
          </h1>

          @if($topic->description)
            <p class="mt-2 text-sm sm:text-base text-gray-600 dark:text-gray-400">
              {{ $topic->description }}
            </p>
          @else
            <p class="mt-2 text-sm sm:text-base text-gray-600 dark:text-gray-400">
              Explore groups related to <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $topic->name }}</span>.
            </p>
          @endif

          <div class="mt-3 inline-flex items-center gap-2 text-[11px] sm:text-xs font-semibold text-yellow-900 dark:text-yellow-100 bg-yellow-400/15 dark:bg-yellow-500/20 border border-yellow-300/40 dark:border-yellow-500/40 rounded-full px-3 py-1">
            <span class="h-1.5 w-1.5 rounded-full bg-yellow-400"></span>
            {{ number_format($groupCount) }} {{ Str::plural('Group', $groupCount) }}
          </div>
        </div>

        <div class="flex items-center gap-2 md:self-start">
          <a href="{{ route('topics.index') }}"
             class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full
                    bg-white/70 dark:bg-gray-900/60 backdrop-blur
                    text-gray-900 dark:text-gray-100 text-sm font-semibold
                    border border-gray-300/70 dark:border-gray-700/80
                    shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all
                    focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -ml-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12l7.5-7.5M3 12h18"/>
            </svg>
            Back
          </a>
        </div>
      </div>
    </div>
  </header>

  <section>
    @if($groupCount > 0)
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
        @foreach($topic->groups as $group)
          <a href="{{ route('groups.show', $group) }}"
             class="group block p-4 sm:p-6 rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-[0_16px_40px_-20px_rgba(0,0,0,0.30)] hover:shadow-[0_30px_70px_-30px_rgba(0,0,0,0.55)] hover:-translate-y-0.5 transition-all">
            <div class="flex items-start justify-between gap-3">
              <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100 break-words">
                {{ $group->name }}
              </h2>

              @auth
                @if($group->members->contains(auth()->id()))
                  <span class="shrink-0 inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-green-500/15 dark:bg-green-600/20 text-green-800 dark:text-green-100 border border-green-400/40 dark:border-green-500/30">
                    <span class="h-1.5 w-1.5 rounded-full bg-green-400"></span>
                    Joined
                  </span>
                @endif
              @endauth
            </div>

            <p class="mt-2 text-sm sm:text-base text-gray-600 dark:text-gray-300 line-clamp-2">
              {{ $group->description ?? 'No description.' }}
            </p>

            <div class="mt-4 grid grid-cols-1 gap-1 text-xs sm:text-sm">
              <p class="text-gray-500 dark:text-gray-400">
                Members:
                <span class="font-medium text-gray-900 dark:text-gray-100">
                  {{ $group->members->count() }}
                </span>
              </p>
              <p class="text-gray-500 dark:text-gray-400">
                Topics:
                <span class="font-medium text-gray-900 dark:text-gray-100">
                  {{ $group->topics->pluck('name')->join(', ') }}
                </span>
              </p>
            </div>

            <div class="mt-4 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
              <span class="inline-flex items-center gap-1 opacity-90 group-hover:opacity-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12l-7.5 7.5M21 12H3"/>
                </svg>
                View Group
              </span>
            </div>
          </a>
        @endforeach
      </div>
    @else
      <div class="p-10 text-center rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-xl">
        <p class="text-gray-700 dark:text-gray-300">
          No groups are using this topic yet.
        </p>
        <div class="mt-4 flex flex-col sm:flex-row items-center justify-center gap-2">
          <a href="{{ route('groups.index') }}"
             class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full bg-white/70 dark:bg-gray-900/60 backdrop-blur text-gray-900 dark:text-gray-100 text-sm font-semibold border border-gray-300/70 dark:border-gray-700/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition">
            Browse groups
          </a>
          <a href="{{ route('topics.index') }}"
             class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full bg-white/70 dark:bg-gray-900/60 backdrop-blur text-gray-900 dark:text-gray-100 text-sm font-semibold border border-gray-300/70 dark:border-gray-700/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -ml-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12l7.5-7.5M3 12h18"/>
            </svg>
            Back
          </a>
        </div>
      </div>
    @endif
  </section>
</div>
@endsection
