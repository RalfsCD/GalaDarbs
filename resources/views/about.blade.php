@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 py-6 sm:py-8 space-y-4 sm:space-y-6">

  <nav aria-label="Breadcrumb"
       class="rounded-2xl bg-white/70 dark:bg-gray-900/60 backdrop-blur
              border border-gray-200/70 dark:border-gray-800/70 shadow-sm px-3 sm:px-4 py-2">
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
      <li class="text-gray-900 dark:text-gray-100 font-semibold">About</li>
    </ol>
  </nav>

  <section
    class="relative overflow-hidden rounded-3xl p-6 sm:p-8
           bg-gradient-to-br from-yellow-50 via-white to-yellow-100
           dark:from-gray-900 dark:via-gray-900/70 dark:to-gray-900
           border border-yellow-200/60 dark:border-gray-800 shadow-2xl">
    <div class="absolute inset-0 -z-10">
      <div class="absolute -right-16 -top-10 h-56 w-56 rounded-full blur-3xl bg-yellow-300/30 dark:bg-yellow-500/20"></div>
      <div class="absolute -left-20 -bottom-16 h-64 w-64 rounded-full blur-3xl bg-orange-300/25 dark:bg-orange-400/15"></div>
    </div>

    <div class="relative z-10 flex flex-col md:flex-row md:items-start md:justify-between gap-3 sm:gap-4">
      <div class="max-w-2xl">
        <div class="inline-flex items-center gap-2">
          <span class="h-2 w-2 rounded-full bg-yellow-400 shadow-[0_0_20px_theme(colors.yellow.300)] motion-safe:animate-pulse"></span>
          <span class="text-[11px] font-semibold tracking-wide uppercase text-yellow-900/80 dark:text-yellow-100/90">About</span>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight
                   bg-clip-text text-transparent bg-gradient-to-b
                   from-gray-900 to-gray-600 dark:from-white dark:to-gray-300">
          PostPit
        </h1>
        <p class="mt-2 text-sm sm:text-base text-gray-600 dark:text-gray-400">
          A clean, community-first place to share ideas, discover groups, and have good conversations — without the noise.
        </p>
      </div>

      <div class="hidden sm:flex items-center">
        <div class="rounded-2xl px-3 py-1.5 text-[11px] font-bold tracking-wide
                    bg-yellow-400/20 text-yellow-900 dark:bg-yellow-500/20 dark:text-yellow-100
                    border border-yellow-300/40 dark:border-yellow-500/40">
          Community-Driven
        </div>
      </div>
    </div>
  </section>

  <section class="p-4 sm:p-6 rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur
                  border border-gray-200/70 dark:border-gray-800/70 shadow-xl space-y-2">
    <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100">What is PostPit?</h2>
    <p class="text-sm sm:text-base text-gray-700 dark:text-gray-300 leading-relaxed">
      PostPit is a topic- and group-based social space. Join communities you like, post thoughts or links,
      and jump into focused discussions that feel welcoming and easy to follow.
    </p>
  </section>

  <section class="p-4 sm:p-6 rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur
                  border border-gray-200/70 dark:border-gray-800/70 shadow-xl">
    <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100 mb-3">Why you’ll like it</h2>
    <div class="grid sm:grid-cols-3 gap-3 sm:gap-4">
      <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-2">
          <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-yellow-400/20 text-yellow-900 dark:text-yellow-100">💬</span>
          <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">Focused Groups</h3>
        </div>
        <p class="mt-1.5 text-sm text-gray-700 dark:text-gray-300">Topic-based communities keep threads relevant.</p>
      </div>

      <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-2">
          <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-yellow-400/20 text-yellow-900 dark:text-yellow-100">⚡</span>
          <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">Fast & Friendly</h3>
        </div>
        <p class="mt-1.5 text-sm text-gray-700 dark:text-gray-300">Smooth posting with a UI that stays out of the way.</p>
      </div>

      <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-2">
          <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-yellow-400/20 text-yellow-900 dark:text-yellow-100">🛡️</span>
          <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">Respectful by Design</h3>
        </div>
        <p class="mt-1.5 text-sm text-gray-700 dark:text-gray-300">Tools and norms that keep conversations healthy.</p>
      </div>
    </div>
  </section>

  <section class="p-4 sm:p-6 rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur
                  border border-gray-200/70 dark:border-gray-800/70 shadow-xl">
    <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100 mb-3">How it works</h2>
    <ol class="grid sm:grid-cols-3 gap-3 sm:gap-4 list-decimal list-inside">
      <li class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700">
        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">Find groups</p>
        <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">Browse by topic or search.</p>
      </li>
      <li class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700">
        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">Post & discuss</p>
        <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">Share ideas, links, and images.</p>
      </li>
      <li class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700">
        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">Grow together</p>
        <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">Invite friends and set the tone.</p>
      </li>
    </ol>
  </section>

  <section class="p-4 sm:p-6 rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur
                  border border-gray-200/70 dark:border-gray-800/70 shadow-xl">
    <div class="flex flex-col gap-3 sm:gap-4">
      <p class="text-sm sm:text-base text-gray-900 dark:text-gray-100">
        Ready to explore? <span class="font-semibold">Find a community that fits you.</span>
      </p>
      <div class="flex w-full items-stretch gap-2 sm:gap-3">
        <a href="{{ route('groups.index') }}"
           class="flex-1 min-w-0 inline-flex items-center justify-center gap-2
                  px-4 sm:px-5 py-3 sm:py-3.5 rounded-full text-base sm:text-lg font-semibold
                  bg-white/70 dark:bg-gray-900/70 backdrop-blur
                  text-gray-900 dark:text-gray-100
                  border border-gray-300/70 dark:border-gray-700/80
                  shadow-md hover:shadow-lg
                  hover:bg-yellow-50/80 dark:hover:bg-gray-800/80
                  focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600 transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-6 sm:h-6 opacity-90"
               fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M18 18.72a9.094 9.094 0 0 
                     0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 
                     3.198.001.031c0 .225-.012.447-.037.666A11.944 
                     11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 
                     6.062 0 0 1 6 18.719m12 0a5.971 
                     5.971 0 0 0-.941-3.197m0 0A5.995 
                     5.995 0 0 0 12 12.75a5.995 
                     5.995 0 0 0-5.058 2.772m0 
                     0a3 3 0 0 0-4.681 2.72 
                     8.986 8.986 0 0 0 
                     3.74.477m.9-3.2a5.97 
                     5.97 0 0 0-.9 3.2M15 6.75a3 
                     3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 
                     2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 
                     0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
          </svg>
          Explore Groups
        </a>

        <a href="{{ route('topics.index') }}"
           class="flex-1 min-w-0 inline-flex items-center justify-center gap-2
                  px-4 sm:px-5 py-3 sm:py-3.5 rounded-full text-base sm:text-lg font-semibold
                  bg-gradient-to-r from-yellow-400 to-amber-400 text-gray-900
                  hover:from-yellow-500 hover:to-amber-500 active:from-yellow-500 active:to-amber-500
                  dark:from-yellow-500 dark:to-amber-500 dark:hover:from-yellow-400 dark:hover:to-amber-400
                  border border-yellow-300/70 shadow-md hover:shadow-lg
                  focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600 transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-6 sm:h-6 opacity-90"
               fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M17.593 3.322c1.1.128 
                     1.907 1.077 1.907 
                     2.185V21L12 17.25 4.5 
                     21V5.507c0-1.108.806-2.057 
                     1.907-2.185a48.507 48.507 
                     0 0111.186 0z"/>
          </svg>
          Explore Topics
        </a>
      </div>
    </div>
  </section>

</div>
@endsection
