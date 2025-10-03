{{-- =========================
  APP NAVIGATION (desktop + mobile)
  - Yellow dot on active items (incl. Profile & Notifications)
  - Custom Admin icon
  - No chevrons/arrows
========================= --}}

@php
    // Shared counts/flags
    $unreadCount = auth()->check()
        ? auth()->user()->notifications()->whereNull('read_at')->count()
        : 0;

    // Desktop + Mobile link set
    $links = [
        ['name' => 'Home',   'route' => 'dashboard',     'icon' => 'home',                'match' => 'dashboard'],
        ['name' => 'Topics', 'route' => 'topics.index',  'icon' => 'bookmark',            'match' => 'topics.*'],
        ['name' => 'Groups', 'route' => 'groups.index',  'icon' => 'users',               'match' => 'groups.*'],
        ['name' => 'News',   'route' => 'news.index',    'icon' => 'newspaper',           'match' => 'news.*'],
        ['name' => 'About',  'route' => 'about',         'icon' => 'information-circle',  'match' => 'about'],
    ];

    if (auth()->check() && auth()->user()->isAdmin()) {
        // Custom Admin icon; match everything under admin.*
        $links[] = ['name' => 'Admin', 'route' => 'admin.index', 'icon' => 'admin-custom', 'match' => 'admin.*'];
    }

    // helpers
    $isActive = fn(string $pattern) => request()->routeIs($pattern);
@endphp

{{-- DESKTOP SIDEBAR --}}
<nav class="hidden md:flex fixed top-0 left-0 h-screen w-64 
            bg-white dark:bg-gray-900 
            border-r border-gray-200 dark:border-gray-800 
            flex-col z-50 transition-colors duration-300">

    {{-- Logo --}}
    <div class="flex items-center justify-center h-14 border-b border-gray-200 dark:border-gray-800">
        <a href="{{ route('dashboard') }}" class="relative flex items-center justify-center">
            <img id="nav-logo"
                 src="{{ asset('images/LogoDark.png') }}"
                 alt="Logo"
                 class="h-14 w-auto opacity-0 transition-opacity duration-200 ease-out">
        </a>
    </div>

    {{-- Links --}}
    <div class="flex-1 overflow-y-auto py-5 px-4 space-y-2">
        @foreach($links as $link)
            @php $active = $isActive($link['match']); @endphp
            <a href="{{ route($link['route']) }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg 
                      text-gray-700 dark:text-gray-300 
                      hover:bg-gray-100 dark:hover:bg-gray-800 transition 
                      {{ $active ? 'bg-gray-100 dark:bg-gray-800 font-semibold' : '' }}">
                {{-- Icon --}}
                @switch($link['icon'])
                    @case('home')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 
                              1.152-.439 1.591 0L21.75 12M4.5 
                              9.75v10.125c0 .621.504 1.125 
                              1.125 1.125H9.75v-4.875c0-.621.504-1.125 
                              1.125-1.125h2.25c.621 0 1.125.504 
                              1.125 1.125V21h4.125c.621 0 1.125-.504 
                              1.125-1.125V9.75M8.25 21h8.25"/></svg>
                        @break
                    @case('bookmark')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 
                              1.907 1.077 1.907 
                              2.185V21L12 17.25 4.5 
                              21V5.507c0-1.108.806-2.057 
                              1.907-2.185a48.507 48.507 
                              0 0111.186 0z"/></svg>
                        @break
                    @case('users')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
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
                                  3.74.477m.94-3.197a5.971 
                                  5.971 0 0 0-.94 
                                  3.197M15 6.75a3 
                                  3 0 1 1-6 0 3 
                                  3 0 0 1 6 
                                  0Zm6 3a2.25 
                                  2.25 0 1 1-4.5 
                                  0 2.25 2.25 
                                  0 0 1 4.5 
                                  0Zm-13.5 
                                  0a2.25 2.25 0 1 1-4.5 
                                  0 2.25 2.25 0 0 1 4.5 0Z" /></svg>
                        @break
                    @case('newspaper')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 7.5h1.5m-1.5 3h1.5m-7.5 
                                  3h7.5m-7.5 3h7.5m3-9h3.375c.621 
                                  0 1.125.504 1.125 1.125V18a2.25 
                                  2.25 0 0 1-2.25 2.25M16.5 
                                  7.5V18a2.25 2.25 0 0 0 
                                  2.25 2.25M16.5 
                                  7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 
                                  3.75 3 4.254 3 
                                  4.875V18a2.25 
                                  2.25 0 0 0 2.25 
                                  2.25h13.5M6 
                                  7.5h3v3H6v-3Z"/></svg>
                        @break
                    @case('information-circle')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                              d="M11.25 11.25h1.5v6h-1.5v-6zm.75-4.5a.75.75 0 11-1.5 
                              0 .75.75 0 011.5 0zM12 21a9 9 0 100-18 9 9 0 
                              0 0 0 18z"/></svg>
                        @break
                    @case('admin-custom')
                        {{-- Custom admin icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
                        </svg>
                        @break
                @endswitch

                {{-- Yellow active dot --}}
                @if($active)
                  <span aria-hidden="true" class="h-1.5 w-1.5 rounded-full bg-yellow-400 shadow-[0_0_10px_theme(colors.yellow.300)]"></span>
                @endif

                <span>{{ $link['name'] }}</span>
            </a>
        @endforeach

        {{-- Auth-only: Profile + Notifications + Logout --}}
        @auth
            @php $activeProfile = $isActive('profile.*'); @endphp
            <a href="{{ route('profile.show') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg
                      text-gray-700 dark:text-gray-300
                      hover:bg-gray-100 dark:hover:bg-gray-800 transition
                      {{ $activeProfile ? 'bg-gray-100 dark:bg-gray-800 font-semibold' : '' }}">
                @if(auth()->user()->profile_photo_path)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" class="w-6 h-6 rounded-full border border-gray-300 dark:border-gray-600" alt="Profile">
                @else
                    <div class="w-6 h-6 rounded-full bg-gray-400 flex items-center justify-center text-white text-xs font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif

                @if($activeProfile)
                  <span aria-hidden="true" class="h-1.5 w-1.5 rounded-full bg-yellow-400 shadow-[0_0_10px_theme(colors.yellow.300)]"></span>
                @endif

                <span>Profile</span>
            </a>

            @php $activeNotifs = $isActive('notifications.*'); @endphp
            <a href="{{ route('notifications.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg
                      text-gray-700 dark:text-gray-300
                      hover:bg-gray-100 dark:hover:bg-gray-800 transition
                      {{ $activeNotifs ? 'bg-gray-100 dark:bg-gray-800 font-semibold' : '' }}">
                {{-- Bell --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.25 18.75a2.25 2.25 0 11-4.5 0m9-5.25V10.5a6.75 
                        6.75 0 10-13.5 0v3l-1.5 3h16.5l-1.5-3z"/>
                </svg>

                @if($activeNotifs)
                  <span aria-hidden="true" class="h-1.5 w-1.5 rounded-full bg-yellow-400 shadow-[0_0_10px_theme(colors.yellow.300)]"></span>
                @endif

                <span>Notifications</span>
                @if($unreadCount > 0)
                    <span class="ml-auto inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold text-white bg-red-600 rounded-full">{{ $unreadCount }}</span>
                @endif
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 w-full text-left px-3 py-2 rounded-lg text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 
                              0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 
                              2.25 0 002.25-2.25V15m3 0l3-3m0 
                              0l-3-3m3 3H9"/></svg>
                    <span>Log Out</span>
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="block px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">Login</a>
            <a href="{{ route('register') }}" class="block px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">Register</a>
        @endauth
    </div>

    {{-- Bottom: Theme toggle --}}
    <div class="p-4 border-t border-gray-200 dark:border-gray-800">
        <button id="theme-toggle" type="button"
                class="flex items-center gap-2 px-3 py-2 w-full rounded-lg 
                       hover:bg-gray-100 dark:hover:bg-gray-800 
                       text-gray-700 dark:text-gray-300 transition">
            <svg id="theme-toggle-light-icon" class="w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 3v1.5m0 15V21m9-9h-1.5M4.5 
                      12H3m15.364-7.364l-1.06 1.06M7.757 
                      16.243l-1.06 1.06M16.243 16.243l1.06 
                      1.06M7.757 7.757l1.06 1.06M12 
                      6.75a5.25 5.25 0 100 10.5 
                      5.25 5.25 0 000-10.5z"/></svg>
            <svg id="theme-toggle-dark-icon" class="w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round"
                      d="M21.752 15.002A9.718 9.718 
                      0 0112 21.75a9.75 9.75 
                      0 01-9.75-9.75 9.75 9.75 
                      0 016.748-9.29 7.5 7.5 
                      0 0012.754 12.292z"/></svg>
            <span>Toggle Theme</span>
        </button>
    </div>
</nav>

{{-- MOBILE TOP BAR --}}
<header class="md:hidden fixed top-0 inset-x-0 h-14 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 z-50 flex items-center justify-between px-3"
        style="padding-top: env(safe-area-inset-top); padding-left: env(safe-area-inset-left); padding-right: env(safe-area-inset-right);">
    <button id="mobile-nav-open" type="button" aria-label="Open menu" aria-controls="mobile-drawer" aria-expanded="false"
            class="inline-flex items-center justify-center w-10 h-10 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
        {{-- Hamburger --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5"/>
        </svg>
    </button>

    <a href="{{ route('dashboard') }}" class="flex items-center justify-center">
        <img id="nav-logo-mobile" src="{{ asset('images/LogoDark.png') }}" alt="Logo" class="h-8 sm:h-10 w-auto opacity-0 transition-opacity duration-200 ease-out">
    </a>

    <div class="w-10"></div>
</header>

{{-- MOBILE DRAWER + OVERLAY --}}
<div id="mobile-drawer-overlay" class="md:hidden fixed inset-0 bg-black/40 hidden z-40"></div>

<aside id="mobile-drawer" role="dialog" aria-modal="true" aria-hidden="true"
       class="md:hidden fixed inset-y-0 left-0 w-[88vw] sm:w-72
              bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800
              transform -translate-x-full transition-transform duration-300 z-50"
       style="padding-left: env(safe-area-inset-left); padding-right: env(safe-area-inset-right);">

    {{-- Drawer header --}}
    <div class="h-14 px-4 flex items-center justify-between border-b border-gray-200 dark:border-gray-800"
         style="padding-top: env(safe-area-inset-top);">
        <a href="{{ route('dashboard') }}" class="flex items-center">
            <img id="nav-logo-mobile-header" src="{{ asset('images/LogoDark.png') }}" alt="Logo" class="h-8 sm:h-10 w-auto opacity-0 transition-opacity duration-200 ease-out">
        </a>
        <button id="mobile-nav-close" type="button" aria-label="Close menu"
                class="inline-flex items-center justify-center w-10 h-10 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Drawer links (same set) --}}
    <div class="flex-1 overflow-y-auto py-5 px-4 space-y-2">
        @foreach($links as $link)
            @php $active = $isActive($link['match']); @endphp
            <a href="{{ route($link['route']) }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg 
                      text-gray-700 dark:text-gray-300 
                      hover:bg-gray-100 dark:hover:bg-gray-800 transition 
                      {{ $active ? 'bg-gray-100 dark:bg-gray-800 font-semibold' : '' }}">
                @switch($link['icon'])
                    @case('home')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 
                              1.152-.439 1.591 0L21.75 12M4.5 
                              9.75v10.125c0 .621.504 1.125 
                              1.125 1.125H9.75v-4.875c0-.621.504-1.125 
                              1.125-1.125h2.25c.621 0 1.125.504 
                              1.125 1.125V21h4.125c.621 0 1.125-.504 
                              1.125-1.125V9.75M8.25 21h8.25"/></svg>
                        @break
                    @case('bookmark')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 
                              1.907 1.077 1.907 
                              2.185V21L12 17.25 4.5 
                              21V5.507c0-1.108.806-2.057 
                              1.907-2.185a48.507 48.507 
                              0 0111.186 0z"/></svg>
                        @break
                    @case('users')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
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
                                  3.74.477m.94-3.197a5.971 
                                  5.971 0 0 0-.94 
                                  3.197M15 6.75a3 
                                  3 0 1 1-6 0 3 
                                  3 0 0 1 6 
                                  0Zm6 3a2.25 
                                  2.25 0 1 1-4.5 
                                  0 2.25 2.25 
                                  0 0 1 4.5 
                                  0Zm-13.5 
                                  0a2.25 2.25 0 1 1-4.5 
                                  0 2.25 2.25 0 0 1 4.5 0Z" /></svg>
                        @break
                    @case('newspaper')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 7.5h1.5m-1.5 3h1.5m-7.5 
                                  3h7.5m-7.5 3h7.5m3-9h3.375c.621 
                                  0 1.125.504 1.125 1.125V18a2.25 
                                  2.25 0 0 1-2.25 2.25M16.5 
                                  7.5V18a2.25 2.25 0 0 0 
                                  2.25 2.25M16.5 
                                  7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 
                                  3.75 3 4.254 3 
                                  4.875V18a2.25 
                                  2.25 0 0 0 2.25 
                                  2.25h13.5M6 
                                  7.5h3v3H6v-3Z"/></svg>
                        @break
                    @case('information-circle')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                              d="M11.25 11.25h1.5v6h-1.5v-6zm.75-4.5a.75.75 0 11-1.5 
                              0 .75.75 0 011.5 0zM12 21a9 9 0 100-18 9 9 0 0 0 0 18z"/></svg>
                        @break
                    @case('admin-custom')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
                        </svg>
                        @break
                @endswitch

                @if($active)
                  <span aria-hidden="true" class="h-1.5 w-1.5 rounded-full bg-yellow-400 shadow-[0_0_10px_theme(colors.yellow.300)]"></span>
                @endif

                <span>{{ $link['name'] }}</span>
            </a>
        @endforeach

        @auth
            @php $activeProfile = $isActive('profile.*'); @endphp
            <a href="{{ route('profile.show') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg
                      text-gray-700 dark:text-gray-300
                      hover:bg-gray-100 dark:hover:bg-gray-800 transition
                      {{ $activeProfile ? 'bg-gray-100 dark:bg-gray-800 font-semibold' : '' }}">
                @if(auth()->user()->profile_photo_path)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" class="w-6 h-6 rounded-full border border-gray-300 dark:border-gray-600" alt="Profile">
                @else
                    <div class="w-6 h-6 rounded-full bg-gray-400 flex items-center justify-center text-white text-xs font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif

                @if($activeProfile)
                  <span aria-hidden="true" class="h-1.5 w-1.5 rounded-full bg-yellow-400 shadow-[0_0_10px_theme(colors.yellow.300)]"></span>
                @endif

                <span>Profile</span>
            </a>

            @php $activeNotifs = $isActive('notifications.*'); @endphp
            <a href="{{ route('notifications.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg 
                      text-gray-700 dark:text-gray-300 
                      hover:bg-gray-100 dark:hover:bg-gray-800 transition 
                      {{ $activeNotifs ? 'bg-gray-100 dark:bg-gray-800 font-semibold' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                          d="M14.25 18.75a2.25 2.25 0 11-4.5 0m9-5.25V10.5a6.75 
                          6.75 0 10-13.5 0v3l-1.5 3h16.5l-1.5-3z"/></svg>

                @if($activeNotifs)
                  <span aria-hidden="true" class="h-1.5 w-1.5 rounded-full bg-yellow-400 shadow-[0_0_10px_theme(colors.yellow.300)]"></span>
                @endif

                <span>Notifications</span>
                @if($unreadCount > 0)
                    <span class="ml-auto inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold text-white bg-red-600 rounded-full">{{ $unreadCount }}</span>
                @endif
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 w-full text-left px-3 py-2 rounded-lg text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 
                              0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 
                              2.25 0 002.25-2.25V15m3 0l3-3m0 
                              0l-3-3m3 3H9"/></svg>
                    <span>Log Out</span>
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="block px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">Login</a>
            <a href="{{ route('register') }}" class="block px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">Register</a>
        @endauth
    </div>

    {{-- Drawer bottom: Theme toggle --}}
    <div class="p-4 border-t border-gray-200 dark:border-gray-800"
         style="padding-bottom: env(safe-area-inset-bottom);">
        <button id="theme-toggle-mobile" type="button"
                class="flex items-center gap-2 px-3 py-2 w-full rounded-lg 
                       hover:bg-gray-100 dark:hover:bg-gray-800 
                       text-gray-700 dark:text-gray-300 transition">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 3v1.5m0 15V21m9-9h-1.5M4.5 
                      12H3m15.364-7.364l-1.06 1.06M7.757 
                      16.243l-1.06 1.06M16.243 16.243l1.06 
                      1.06M7.757 7.757l1.06 1.06M12 
                      6.75a5.25 5.25 0 100 10.5 
                      5.25 5.25 0 000-10.5z"/>
            </svg>
            <span>Toggle Theme</span>
        </button>
    </div>
</aside>

{{-- Spin + fade swap for logo --}}
<style>
@keyframes spin-swap {
  0%   { transform: rotate(0deg);   opacity: 1; }
  49%  { opacity: 0; }
  50%  { transform: rotate(180deg); opacity: 0; }
  100% { transform: rotate(360deg); opacity: 1; }
}
.spin-once { animation: spin-swap 0.7s ease-in-out forwards; }
@media (prefers-reduced-motion: reduce) {
  .spin-once { animation: none !important; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const html = document.documentElement;

    // Logos
    const logos = [
        document.getElementById('nav-logo'),
        document.getElementById('nav-logo-mobile'),
        document.getElementById('nav-logo-mobile-header')
    ].filter(Boolean);

    // Theme toggles
    const themeToggles = [
        document.getElementById('theme-toggle'),
        document.getElementById('theme-toggle-mobile')
    ].filter(Boolean);

    // Mobile drawer elements
    const openBtn  = document.getElementById('mobile-nav-open');
    const closeBtn = document.getElementById('mobile-nav-close');
    const drawer   = document.getElementById('mobile-drawer');
    const overlay  = document.getElementById('mobile-drawer-overlay');

    const SRC_LIGHT = "{{ asset('images/LogoDark.png') }}";   // light UI → dark logo
    const SRC_DARK  = "{{ asset('images/LogoWhite.png') }}";  // dark UI → white logo

    const isDarkPref = () =>
        (localStorage.getItem('color-theme') === 'dark') ||
        (!localStorage.getItem('color-theme') && window.matchMedia('(prefers-color-scheme: dark)').matches) ||
        html.classList.contains('dark');

    const initLogos = () => {
        const dark = isDarkPref();
        logos.forEach(l => {
            if (!l) return;
            l.src = dark ? SRC_DARK : SRC_LIGHT;
            requestAnimationFrame(() => l.classList.remove('opacity-0'));
        });
    };
    initLogos();

    const spinSwapLogos = () => {
        logos.forEach(l => l && l.classList.add('spin-once'));
        setTimeout(() => {
            const darkAfter = html.classList.contains('dark');
            logos.forEach(l => l && (l.src = darkAfter ? SRC_DARK : SRC_LIGHT));
        }, 350);
        setTimeout(() => logos.forEach(l => l && l.classList.remove('spin-once')), 720);
    };

    themeToggles.forEach(btn => btn?.addEventListener('click', spinSwapLogos));

    // Drawer helpers
    const setAria = (open) => {
        drawer?.setAttribute('aria-hidden', open ? 'false' : 'true');
        openBtn?.setAttribute('aria-expanded', open ? 'true' : 'false');
    };

    const openDrawer = () => {
        drawer?.classList.remove('-translate-x-full');
        overlay?.classList.remove('hidden');
        setAria(true);
        document.body.classList.add('overflow-hidden');

        trapFocusInit();
        firstFocusable?.focus();
    };
    const closeDrawer = () => {
        drawer?.classList.add('-translate-x-full');
        setAria(false);
        setTimeout(() => overlay?.classList.add('hidden'), 200);
        document.body.classList.remove('overflow-hidden');
    };

    openBtn?.addEventListener('click', openDrawer);
    closeBtn?.addEventListener('click', closeDrawer);
    overlay?.addEventListener('click', closeDrawer);
    window.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeDrawer(); });

    // Focus trap
    let firstFocusable, lastFocusable;
    const trapFocusInit = () => {
        const focusables = drawer?.querySelectorAll('a, button, input, select, textarea, [tabindex]:not([tabindex="-1"])');
        if (!focusables || focusables.length === 0) return;
        firstFocusable = focusables[0];
        lastFocusable  = focusables[focusables.length - 1];
    };
    drawer?.addEventListener('keydown', (e) => {
        if (e.key !== 'Tab') return;
        const active = document.activeElement;
        if (e.shiftKey) {
            if (active === firstFocusable) {
                e.preventDefault();
                lastFocusable?.focus();
            }
        } else {
            if (active === lastFocusable) {
                e.preventDefault();
                firstFocusable?.focus();
            }
        }
    });

    // Close drawer after navigating
    drawer?.addEventListener('click', (e) => {
        const target = e.target.closest('a');
        if (target) closeDrawer();
    });
});
</script>
