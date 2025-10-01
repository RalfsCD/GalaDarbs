{{-- =============================================================
  resources/views/notifications/index.blade.php — Tailwind-only
  - Default view: UNREAD ONLY (does not mark them read)
  - Toggle pill switches to "Show all" (via ?all=1)
  - Breadcrumbs + gradient hero to match the rest of your app
============================================================= --}}

@extends('layouts.app')

@section('content')
@php
  // We expect $notifications to be a collection (read + unread)
  $unreadCount = $notifications->whereNull('read_at')->count();
  $showAll     = request()->boolean('all'); // ?all=1 shows everything
  $items       = $showAll ? $notifications : $notifications->whereNull('read_at');

  // Build toggle URL (preserve other params)
  $params = request()->all();
  if ($showAll) { unset($params['all']); } else { $params['all'] = 1; }
  $toggleUrl = url()->current() . (count($params) ? ('?' . http_build_query($params)) : '');
@endphp

<div class="max-w-7xl mx-auto px-3 sm:px-6 py-6 sm:py-8 space-y-4 sm:space-y-6">

  {{-- ===== Breadcrumbs ===== --}}
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
      <li class="text-gray-900 dark:text-gray-100 font-semibold">Notifications</li>
    </ol>
  </nav>

  {{-- ===== Hero ===== --}}
  <header
    class="relative overflow-hidden rounded-3xl p-6 sm:p-8
           bg-gradient-to-br from-yellow-50 via-white to-yellow-100
           dark:from-gray-900 dark:via-gray-900/70 dark:to-gray-900
           border border-yellow-200/60 dark:border-gray-800 shadow-2xl">
    <div class="absolute inset-0 -z-10">
      <div class="absolute -right-16 -top-10 h-56 w-56 rounded-full blur-3xl bg-yellow-300/30 dark:bg-yellow-500/20"></div>
      <div class="absolute -left-20 -bottom-16 h-64 w-64 rounded-full blur-3xl bg-orange-300/25 dark:bg-orange-400/15"></div>
    </div>

    <div class="relative z-10 flex flex-col md:flex-row md:items-start md:justify-between gap-4">
      <div class="max-w-2xl">
        <div class="inline-flex items-center gap-2 mb-1">
          <span class="h-2 w-2 rounded-full bg-yellow-400 shadow-[0_0_18px_theme(colors.yellow.300)] motion-safe:animate-pulse"></span>
          <span class="text-[11px] font-semibold tracking-wide uppercase text-yellow-900/80 dark:text-yellow-100/90">Inbox</span>
        </div>

        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight
                   bg-clip-text text-transparent
                   bg-gradient-to-b from-gray-900 to-gray-600
                   dark:from-white dark:to-gray-300">
          Notifications
        </h1>

        <p class="mt-2 text-sm sm:text-base text-gray-600 dark:text-gray-400">
          @if(!$showAll)
            Showing <span class="font-semibold">{{ $unreadCount }}</span> unread.
          @else
            Showing <span class="font-semibold">{{ $notifications->count() }}</span> total.
          @endif
        </p>
      </div>

      {{-- Actions (toggle + refresh) --}}
      <div class="flex items-center gap-2 md:self-start">
        <a href="{{ $toggleUrl }}"
           class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full text-sm font-semibold
                  bg-white/70 dark:bg-gray-900/60 backdrop-blur
                  text-gray-900 dark:text-gray-100
                  border border-gray-300/70 dark:border-gray-700/80
                  shadow-sm hover:shadow-md hover:-translate-y-0.5 transition">
          @if($showAll)
            Show unread
          @else
            Show all
          @endif
        </a>

        <a href="{{ url()->current() }}{{ $showAll ? '?all=1' : '' }}"
           class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full text-sm font-semibold
                  bg-yellow-400 text-gray-900 border border-yellow-300/70
                  shadow-sm hover:shadow-md hover:-translate-y-0.5 transition
                  dark:bg-yellow-500 dark:hover:bg-yellow-400 dark:text-gray-900">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0 1 12.728-5.303M19.5 12A7.5 7.5 0 0 1 6.772 17.303M19.5 5.25V9h-3.75"/>
          </svg>
          Refresh
        </a>
      </div>
    </div>
  </header>

  {{-- ===== Notifications Grid ===== --}}
  @if($items->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
      @foreach($items as $notification)
        @php
          $data     = $notification->data ?? [];
          $type     = $data['type'] ?? 'info';
          $isUnread = is_null($notification->read_at ?? null);
          $iconWrap = 'flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center';
          $ring     = $isUnread ? 'ring-2 ring-yellow-300 dark:ring-yellow-600' : '';
        @endphp

        <div class="p-4 sm:p-6 rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur
                    border border-gray-200/70 dark:border-gray-800/70
                    shadow-[0_16px_40px_-20px_rgba(0,0,0,0.30)] hover:shadow-[0_28px_60px_-28px_rgba(0,0,0,0.45)]
                    transition {{ $ring }}">
          <div class="flex items-start gap-3 sm:gap-4">
            {{-- Icon by type --}}
            @if($type === 'post_deleted')
              <div class="{{ $iconWrap }} bg-red-100 dark:bg-red-900/30">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"
                     class="w-5 h-5 sm:w-6 sm:h-6 text-red-600 dark:text-red-400">
                  <path stroke-linecap="round" stroke-linejoin="round"
                        d="m14.74 9-.346 9m-4.788 0L9.26 9M4.77 5.79l1.07 13.883A2.25 2.25 0 0 0 8.08 21.75h8.38a2.25 2.25 0 0 0 2.24-2.077L19.5 5.79M9 5.25v-.916c0-1.18.91-2.164 2.09-2.201a51.964 51.964 0 0 1 3.32 0C15.59 2.17 16.5 3.154 16.5 4.334V5.25"/>
                </svg>
              </div>
            @elseif($type === 'post_liked')
              <div class="{{ $iconWrap }} bg-pink-100 dark:bg-pink-900/30">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                     fill="currentColor" class="w-5 h-5 sm:w-6 sm:h-6 text-pink-600 dark:text-pink-400">
                  <path d="M11.645 20.91a.75.75 0 0 1-.71 0A25.18 25.18 0 0 1 6 17.108C2.852 15.108 1.13 12.89 1.13 10.5 1.13 7.462 3.592 5 6.63 5c1.47 0 2.77.5 3.78 1.342A5.483 5.483 0 0 1 14.13 5c3.038 0 5.5 2.462 5.5 5.5 0 2.39-1.722 4.608-4.87 6.608a25.18 25.18 0 0 1-4.244 3.17z"/>
                </svg>
              </div>
            @elseif($type === 'post_commented')
              <div class="{{ $iconWrap }} bg-blue-100 dark:bg-blue-900/30">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"
                     class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600 dark:text-blue-400">
                  <path stroke-linecap="round" stroke-linejoin="round"
                        d="M7.5 8.25h9M7.5 12h6m-6 3.75h3M12 3a9 9 0 1 1 0 18 9 9 0 0 1 0-18z"/>
                </svg>
              </div>
            @else
              <div class="{{ $iconWrap }} bg-gray-100 dark:bg-gray-900/40">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"
                     class="w-5 h-5 sm:w-6 sm:h-6 text-gray-600 dark:text-gray-300">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
                </svg>
              </div>
            @endif

            {{-- Content --}}
            <div class="flex-1 min-w-0">
              <p class="text-sm sm:text-base text-gray-900 dark:text-gray-100 leading-relaxed break-words">
                @php $title = $data['post_title'] ?? ''; $who = $data['user_name'] ?? 'Someone'; @endphp
                @switch($type)
                  @case('post_deleted')
                    Your post "<span class="font-semibold">{{ $title }}</span>" was reported and removed by an admin.
                    @break
                  @case('post_liked')
                    <span class="font-semibold">{{ $who }}</span> liked your post "<span class="font-semibold">{{ $title }}</span>".
                    @break
                  @case('post_commented')
                    <span class="font-semibold">{{ $who }}</span> commented on your post "<span class="font-semibold">{{ $title }}</span>".
                    @break
                  @default
                    {{ $data['message'] ?? 'You have a new notification.' }}
                @endswitch
              </p>

              <p class="text-[11px] sm:text-xs text-gray-500 dark:text-gray-400 mt-2 flex items-center gap-2">
                {{ $notification->created_at->diffForHumans() }}
                @if($isUnread)
                  <span class="inline-block w-2 h-2 rounded-full bg-yellow-400"></span>
                  <span class="sr-only">Unread</span>
                @endif
              </p>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @else
    {{-- No unread -> nudge to show all --}}
    @if(!$showAll)
      <div class="p-8 text-center rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur
                  border border-gray-200/70 dark:border-gray-800/70 shadow-xl">
        <p class="text-gray-700 dark:text-gray-300">You’re all caught up 🎉</p>
        <a href="{{ url()->current() }}?all=1"
           class="inline-flex items-center gap-1.5 mt-4 px-3.5 py-2 rounded-full
                  bg-white/70 dark:bg-gray-900/60 backdrop-blur
                  text-gray-900 dark:text-gray-100 text-sm font-semibold
                  border border-gray-300/70 dark:border-gray-700/80
                  shadow-sm hover:shadow-md hover:-translate-y-0.5 transition">
          View all notifications
        </a>
      </div>
    @else
      <div class="p-8 text-center rounded-3xl bg-white/80 dark:bg-gray-900/70 backdrop-blur
                  border border-gray-200/70 dark:border-gray-800/70 shadow-xl">
        <p class="text-gray-700 dark:text-gray-300">No notifications yet.</p>
      </div>
    @endif
  @endif

</div>
@endsection
