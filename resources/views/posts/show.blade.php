@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 py-6 sm:py-8 space-y-4 sm:space-y-6">
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
             stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
      </li>
      <li>
        <a href="{{ route('groups.index') }}"
           class="inline-flex items-center gap-1 px-2 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition">
          <span class="font-semibold">Groups</span>
        </a>
      </li>
      <li aria-hidden="true" class="text-gray-400">
        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
      </li>
      <li>
        <a href="{{ route('groups.show', $post->group) }}"
           class="inline-flex items-center gap-1 px-2 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition">
          <span class="font-semibold truncate max-w-[140px] sm:max-w-none">{{ $post->group->name }}</span>
        </a>
      </li>
      <li aria-hidden="true" class="text-gray-400">
        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
      </li>
      <li class="text-gray-900 dark:text-gray-100 font-semibold">Post</li>
    </ol>
  </nav>
  <header
    class="relative overflow-hidden rounded-3xl p-6 sm:p-8
           bg-gradient-to-br from-yellow-50 via-white to-yellow-100
           dark:from-gray-900 dark:via-gray-900/70 dark:to-gray-900
           border border-yellow-200/60 dark:border-gray-800 shadow-2xl">
    <div class="absolute inset-0 -z-10 opacity-70">
      <div class="absolute -top-24 -right-24 h-72 w-72 rounded-full blur-3xl bg-gradient-to-br from-yellow-300/40 to-orange-400/30 dark:from-yellow-500/25 dark:to-orange-400/20"></div>
      <div class="absolute -bottom-28 -left-20 h-80 w-80 rounded-full blur-3xl bg-gradient-to-tr from-white/40 to-yellow-200/40 dark:from-gray-800/40 dark:to-yellow-500/20"></div>
    </div>
    <div class="relative z-10 flex flex-col md:flex-row md:items-start md:justify-between gap-3 sm:gap-4">
      <div class="max-w-full md:max-w-2xl min-w-0">
        <div class="inline-flex items-center gap-2 mb-1">
          <span class="h-2 w-2 rounded-full bg-yellow-400 shadow-[0_0_20px_theme(colors.yellow.300)] motion-safe:animate-pulse"></span>
          <span class="text-[11px] font-semibold tracking-wide uppercase text-yellow-900/80 dark:text-yellow-100/90">Post</span>
        </div>
        <h1 class="text-xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight bg-clip-text text-transparent truncate bg-gradient-to-b from-gray-900 to-gray-600 dark:from-white dark:to-gray-300">
          {{ $post->title ?: 'Untitled Post' }}
        </h1>
        <p class="mt-1 text-[13px] sm:text-base text-gray-700 dark:text-gray-300">
          in <a href="{{ route('groups.show', $post->group) }}" class="font-semibold underline underline-offset-4 hover:opacity-90">{{ $post->group->name }}</a>
          <span class="text-gray-400">•</span>
          <span class="text-gray-600 dark:text-gray-400">by {{ $post->user->name }}</span>
          <span class="text-gray-400">•</span>
          <span class="text-gray-500 dark:text-gray-400">{{ $post->created_at->diffForHumans() }}</span>
        </p>
      </div>
      <div class="flex items-center gap-2 md:self-start">
        <a href="{{ route('groups.show', $post->group) }}"
           class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full
                  bg-white/70 dark:bg-gray-900/60 backdrop-blur
                  text-gray-900 dark:text-gray-100 text-sm font-semibold
                  border border-gray-300/70 dark:border-gray-700/80
                  shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -ml-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12l7.5-7.5M3 12h18"/>
          </svg>
          Back to group
        </a>
      </div>
    </div>
  </header>
  <section>
    @include('partials.post-card', ['post' => $post])
  </section>
</div>
<div id="imageModal" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50">
  <span id="closeImageModal" class="absolute top-6 right-8 text-white text-4xl cursor-pointer">&times;</span>
  <img id="modalImage" src="" class="max-h-[90%] max-w-[90%] rounded-xl shadow-2xl" alt="Preview">
</div>
@endsection

@section('scripts')
  @include('partials.post-scripts')
@endsection
