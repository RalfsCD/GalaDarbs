{{-- =============================================================
  resources/views/profile.blade.php — Tailwind-only
  - Breadcrumbs (PostPit > Profile)
  - Hero matches Topics/Groups styling
  - Polished "My Posts" grid
============================================================= --}}

@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 py-6 sm:py-8 space-y-4 sm:space-y-6">

  {{-- ===== Breadcrumbs ===== --}}
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
      <li class="text-gray-900 dark:text-gray-100 font-semibold">Profile</li>
    </ol>
  </nav>

  {{-- ===== Hero Header ===== --}}
  <header
    class="relative overflow-hidden rounded-3xl p-6 sm:p-8
           bg-gradient-to-br from-yellow-50 via-white to-yellow-100
           dark:from-gray-900 dark:via-gray-900/70 dark:to-gray-900
           border border-yellow-200/60 dark:border-gray-800 shadow-2xl">

    {{-- ambient blobs --}}
    <div class="absolute inset-0 -z-10">
      <div class="absolute -right-16 -top-10 h-56 w-56 rounded-full blur-3xl bg-yellow-300/30 dark:bg-yellow-500/20"></div>
      <div class="absolute -left-20 -bottom-16 h-64 w-64 rounded-full blur-3xl bg-orange-300/25 dark:bg-orange-400/15"></div>
    </div>

    <div class="relative z-10 flex flex-col md:flex-row md:items-start md:justify-between gap-4">

      <div class="flex items-center gap-3 sm:gap-4 min-w-0">
        {{-- Avatar --}}
        <div class="shrink-0 w-14 h-14 sm:w-16 sm:h-16 rounded-full overflow-hidden ring-2 ring-yellow-300/60 dark:ring-yellow-600/50 shadow">
          <img
            src="{{ $user->profile_photo_path
                    ? asset('storage/' . $user->profile_photo_path)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=ddd&color=555' }}"
            alt="{{ $user->name }}"
            class="w-full h-full object-cover">
        </div>

        <div class="min-w-0">
          <div class="flex items-center gap-2">
            <span class="inline-block w-2 h-2 rounded-full bg-yellow-400 shadow-[0_0_14px_theme(colors.yellow.300)]"></span>
            <h1 class="text-xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight
                       bg-clip-text text-transparent truncate
                       bg-gradient-to-b from-gray-900 to-gray-600
                       dark:from-white dark:to-gray-300">
              {{ $user->name }}
            </h1>
          </div>

          <div class="mt-1 flex flex-wrap items-center gap-2 text-[12px] sm:text-sm">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full
                         bg-gray-900/5 dark:bg-white/10
                         text-gray-700 dark:text-gray-200 border border-gray-200/70 dark:border-gray-700/70">
              {{ ucfirst($user->role ?? 'user') }}
            </span>
            <span class="text-gray-500 dark:text-gray-400 truncate">{{ $user->email }}</span>
          </div>
        </div>
      </div>

      {{-- Settings --}}
      <div class="md:self-start">
        <a href="{{ route('profile.settings') }}"
           class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full
                  bg-white/70 dark:bg-gray-900/60 backdrop-blur
                  text-gray-900 dark:text-gray-100 text-sm font-semibold
                  border border-gray-300/70 dark:border-gray-700/80
                  shadow-sm hover:shadow-md hover:-translate-y-0.5
                  hover:bg-yellow-50/60 dark:hover:bg-gray-800/80
                  transition-all focus:outline-none focus:ring-2
                  focus:ring-yellow-300 dark:focus:ring-yellow-600">
          {{-- New settings icon (cog-6-tooth) --}}
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -ml-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
          </svg>
          Settings
        </a>
      </div>
    </div>
  </header>

  {{-- ===== User Posts ===== --}}
  <section class="rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-xl p-4 sm:p-6">
    <div class="flex items-center justify-between gap-3">
      <h2 class="text-lg sm:text-2xl font-extrabold tracking-tight text-gray-900 dark:text-gray-100">My Posts</h2>
      @if($posts->count())
        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold
                     bg-yellow-400/15 dark:bg-yellow-500/20 text-yellow-900 dark:text-yellow-100
                     border border-yellow-300/40 dark:border-yellow-500/40">
          <span class="h-1.5 w-1.5 rounded-full bg-yellow-400"></span>
          {{ number_format($posts->count()) }}
        </span>
      @endif
    </div>

    @if($posts->count())
      <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
        @foreach($posts as $post)
          <a href="{{ route('posts.show', $post) }}" class="group block">
            <div class="p-4 sm:p-5 rounded-2xl
                        bg-white/80 dark:bg-gray-900/70 backdrop-blur
                        border border-gray-200/70 dark:border-gray-800/70
                        shadow-[0_16px_40px_-20px_rgba(0,0,0,0.30)]
                        hover:shadow-[0_28px_60px_-28px_rgba(0,0,0,0.45)]
                        transition">

              {{-- Group pill --}}
              <div class="mb-2 flex items-center gap-2 text-[12px] sm:text-sm">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full
                             bg-yellow-100/80 dark:bg-yellow-500/20
                             text-yellow-800 dark:text-yellow-100
                             border border-yellow-300/60 dark:border-yellow-500/30">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0z"/>
                  </svg>
                  <span class="font-semibold truncate max-w-[160px] sm:max-w-none">{{ $post->group->name }}</span>
                </span>
                <span class="text-gray-400">•</span>
                <span class="text-gray-500 dark:text-gray-400">{{ $post->created_at->diffForHumans() }}</span>
              </div>

              {{-- Title --}}
              <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-gray-100 break-words">
                {{ $post->title }}
              </h3>

              {{-- Content --}}
              @if(filled($post->content))
                <p class="text-[13.5px] sm:text-sm text-gray-600 dark:text-gray-300 mt-2 line-clamp-3">
                  {{ $post->content }}
                </p>
              @endif

              {{-- Media preview --}}
              @if($post->media_path)
                <div class="mt-3 overflow-hidden rounded-lg">
                  <img src="{{ asset('storage/' . $post->media_path) }}"
                       alt="Post Image"
                       class="w-full object-cover max-h-40 group-hover:scale-[1.01] transition-transform duration-300">
                </div>
              @endif
            </div>
          </a>
        @endforeach
      </div>
    @else
      <p class="mt-3 text-sm sm:text-base text-gray-600 dark:text-gray-400">No posts yet.</p>
    @endif
  </section>
</div>
@endsection
