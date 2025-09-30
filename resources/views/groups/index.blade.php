@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 py-4 sm:py-6 space-y-4 sm:space-y-6">

    @php
        $hasPaginator = method_exists($groups, 'total');
        $totalGroups  = $hasPaginator ? $groups->total() : (is_countable($groups) ? count($groups) : 0);
        $searching    = request()->filled('search');
        $searchTerm   = request('search', '');
    @endphp

    {{-- Page Header (hero-style; matches topics.index) --}}
    <header
        class="relative overflow-hidden rounded-3xl p-6 sm:p-8
               bg-gradient-to-br from-yellow-100 via-white to-yellow-50
               dark:from-gray-900 dark:via-gray-900/70 dark:to-gray-900
               border border-yellow-200/60 dark:border-gray-800 shadow-xl">
        <div class="relative z-10 flex flex-col gap-5">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">

                <div class="max-w-2xl">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight
                               bg-clip-text text-transparent
                               bg-gradient-to-b from-gray-900 to-gray-600
                               dark:from-white dark:to-gray-300">
                        Groups
                    </h1>

                    <p class="mt-2 text-sm sm:text-base text-gray-700 dark:text-gray-300">
                        Discover communities by interest. Join one — or start your own.
                        @if($searching)
                            <span class="block mt-1">
                                Showing results for
                                <span class="font-semibold text-gray-900 dark:text-gray-100">“{{ $searchTerm }}”</span>.
                            </span>
                        @endif
                    </p>

                    @if($totalGroups)
                        <div class="mt-3 inline-flex items-center gap-2 text-xs font-semibold
                                    text-yellow-900 dark:text-yellow-100
                                    bg-yellow-400/15 dark:bg-yellow-500/20
                                    border border-yellow-300/40 dark:border-yellow-500/40
                                    rounded-full px-3 py-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-400"></span>
                            {{ number_format($totalGroups) }} {{ Str::plural('group', $totalGroups) }}
                        </div>
                    @endif
                </div>

                {{-- Right-side badges / actions (same placement/feel as topics) --}}
                <div class="flex items-center gap-3 md:self-start">
                    <div class="hidden sm:block rounded-2xl px-3 py-1.5 text-[11px] font-bold tracking-wide
                                 bg-yellow-400/20 text-yellow-900 dark:bg-yellow-500/20 dark:text-yellow-100
                                 border border-yellow-300/40 dark:border-yellow-500/40">
                        Explore & Join
                    </div>

                    {{-- Anyone can create a group (keep your existing permission model) --}}
                    <a href="{{ route('groups.create') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-full
                              bg-white/60 dark:bg-gray-900/60 backdrop-blur
                              text-gray-900 dark:text-gray-100
                              border border-gray-300/70 dark:border-gray-700/80
                              shadow-sm hover:shadow-md
                              hover:bg-yellow-400/15 hover:border-yellow-400/50
                              transition focus:outline-none focus:ring-2
                              focus:ring-yellow-300 dark:focus:ring-yellow-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        <span class="font-semibold">Create Group</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- soft decorative blobs (identical to topics.index) -->
        <div class="pointer-events-none absolute -right-10 -top-10 h-40 w-40 rounded-full blur-3xl bg-yellow-300/30 dark:bg-yellow-500/20"></div>
        <div class="pointer-events-none absolute -left-16 -bottom-12 h-48 w-48 rounded-full blur-3xl bg-orange-300/20 dark:bg-orange-400/10"></div>
    </header>

    {{-- Search (identical structure/styles to topics.index) --}}
    <section class="rounded-2xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-lg">
        <form method="GET" action="{{ route('groups.index') }}" class="p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <label for="groups-search" class="sr-only">Search groups</label>

                <div class="relative w-full min-w-0">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <!-- magnifier -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z"/>
                        </svg>
                    </span>
                    <input id="groups-search" type="search" name="search"
                           value="{{ $searchTerm }}"
                           placeholder="Search groups…"
                           autocomplete="off"
                           class="w-full min-w-0 pl-10 pr-3 sm:pr-36 py-2 rounded-lg border border-gray-300 dark:border-gray-700
                                  bg-white dark:bg-gray-950/70 text-sm sm:text-base text-gray-900 dark:text-gray-100
                                  placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600 shadow-sm" />
                    @if($searching)
                        <a href="{{ route('groups.index') }}"
                           class="hidden sm:flex absolute right-2 top-1/2 -translate-y-1/2 items-center gap-1 px-3 py-1.5 rounded-md
                                  bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-700
                                  hover:bg-gray-200 dark:hover:bg-gray-700 transition text-sm">
                            Clear
                        </a>
                    @endif
                </div>

                <div class="flex gap-2 sm:hidden">
                    <button type="submit"
                            class="px-3 py-2 rounded-lg bg-gray-200 dark:bg-gray-700
                                   text-gray-900 dark:text-gray-100 font-medium hover:bg-gray-300
                                   dark:hover:bg-gray-600 transition">
                        Search
                    </button>

                    @if($searching)
                        <a href="{{ route('groups.index') }}"
                           class="px-3 py-2 rounded-lg bg-gray-100 dark:bg-gray-800
                                  text-gray-700 dark:text-gray-200 border border-transparent
                                  hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                            Clear
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </section>

    {{-- Groups List (cards match topics.index cards) --}}
    <section>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @forelse($groups as $group)
                <a href="{{ route('groups.show', $group) }}"
                   class="group block p-4 sm:p-6 rounded-2xl
                          bg-white/80 dark:bg-gray-900/70 backdrop-blur
                          border border-gray-200/70 dark:border-gray-800/70
                          shadow-[0_16px_40px_-20px_rgba(0,0,0,0.3)]
                          hover:shadow-[0_26px_60px_-28px_rgba(0,0,0,0.45)]
                          transition duration-300">
                    <div class="flex items-start justify-between gap-3">
                        <h2 class="text-lg sm:text-xl text-gray-900 dark:text-gray-100 font-bold break-words">
                            {{ $group->name }}
                        </h2>

                        {{-- Members pill (styled like topics’ group count pill) --}}
                        <span class="shrink-0 inline-flex items-center gap-1 px-2.5 py-1 rounded-full
                                     text-xs font-semibold
                                     bg-yellow-100/80 dark:bg-yellow-500/20
                                     text-yellow-800 dark:text-yellow-100
                                     border border-yellow-300/60 dark:border-yellow-500/30">
                            {{ $group->members->count() }} {{ Str::plural('Member', $group->members->count()) }}
                        </span>
                    </div>

                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300 mt-2 line-clamp-2">
                        {{ $group->description ?? 'No description.' }}
                    </p>

                    <div class="mt-4 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                        <span class="inline-flex items-center gap-1 opacity-90 group-hover:opacity-100 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12l-7.5 7.5M21 12H3"/>
                            </svg>
                            View Group
                        </span>
                    </div>
                </a>
            @empty
                <div class="col-span-full">
                    @if($searching)
                        <div class="p-8 text-center rounded-2xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-lg">
                            <div class="mx-auto mb-3 h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-800 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z"/>
                                </svg>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300">
                                No groups match <span class="font-semibold">“{{ $searchTerm }}”</span>.
                            </p>
                            <a href="{{ route('groups.index') }}"
                               class="inline-block mt-4 px-4 py-2.5 rounded-lg
                                      bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                      hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                                Clear search
                            </a>
                        </div>
                    @else
                        <div class="p-10 text-center rounded-2xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-lg">
                            <p class="text-gray-600 dark:text-gray-400">No groups yet.</p>

                            <a href="{{ route('groups.create') }}"
                               class="inline-flex items-center gap-2 mt-4 px-4 py-2.5 rounded-full
                                      bg-white/60 dark:bg-gray-900/60 backdrop-blur
                                      text-gray-900 dark:text-gray-100
                                      border border-gray-300/70 dark:border-gray-700/80
                                      shadow-sm hover:shadow-md
                                      hover:bg-yellow-400/15 hover:border-yellow-400/50
                                      transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                Create the first group
                            </a>
                        </div>
                    @endif
                </div>
            @endforelse
        </div>
    </section>

    {{-- Pagination (keeps search param) --}}
    @if(method_exists($groups, 'hasPages') && $groups->hasPages())
        <div class="pt-2">
            {{ $groups->appends(request()->only('search'))->links() }}
        </div>
    @endif
</div>
@endsection
