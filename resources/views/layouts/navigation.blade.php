<nav class="fixed top-0 left-0 h-screen w-64 
            bg-white dark:bg-gray-900 
            border-r border-gray-200 dark:border-gray-800 
            flex flex-col z-50 transition-colors duration-300">

    <!-- Logo (smaller container, larger image) -->
    <div class="flex items-center justify-center h-14 border-b border-gray-200 dark:border-gray-800">
        <a href="{{ route('dashboard') }}" class="relative flex items-center justify-center">
            <img id="nav-logo"
                 src="{{ asset('images/LogoDark.png') }}"  {{-- default; corrected on load to avoid wrong logo --}}
                 alt="Logo"
                 class="h-14 w-auto opacity-0 transition-opacity duration-200 ease-out">
        </a>
    </div>

    <!-- Navigation Links -->
    <div class="flex-1 overflow-y-auto py-5 px-4 space-y-2">
        @php
            $links = [
                ['name' => 'Home', 'route' => 'dashboard', 'icon' => 'home'],
                ['name' => 'Topics', 'route' => 'topics.index', 'icon' => 'bookmark'],
                ['name' => 'Groups', 'route' => 'groups.index', 'icon' => 'users'],
                ['name' => 'News', 'route' => 'news.index', 'icon' => 'newspaper'],
                ['name' => 'About', 'route' => 'about', 'icon' => 'information-circle'],
            ];

            if(auth()->check() && auth()->user()->isAdmin()) {
                $links[] = ['name' => 'Admin', 'route' => 'admin.index', 'icon' => 'shield-check'];
            }

            $unreadCount = auth()->check()
                ? auth()->user()->notifications()->whereNull('read_at')->count()
                : 0;
        @endphp

        {{-- Main links --}}
        @foreach($links as $link)
            <a href="{{ route($link['route']) }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg 
                      text-gray-700 dark:text-gray-300 
                      hover:bg-gray-100 dark:hover:bg-gray-800 transition 
                      {{ request()->routeIs($link['route']) ? 'bg-gray-100 dark:bg-gray-800 font-semibold' : '' }}">
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
                                  0 2.25 2.25 
                                  0 0 1 4.5 0Z" /></svg>
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
                              000 18z"/></svg>
                        @break
                    @case('shield-check')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 6l7.5 4.5v6c0 4.5-7.5 
                              7.5-7.5 7.5S4.5 21 4.5 
                              16.5v-6L12 6zm0 
                              6.75l-2.25 
                              2.25 4.5 
                              4.5L18 
                              13.5"/></svg>
                        @break
                @endswitch
                <span>{{ $link['name'] }}</span>
            </a>
        @endforeach

        {{-- Auth-only links --}}
        @auth
            <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                @if(auth()->user()->profile_photo_path)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" class="w-6 h-6 rounded-full border border-gray-300 dark:border-gray-600" alt="Profile">
                @else
                    <div class="w-6 h-6 rounded-full bg-gray-400 flex items-center justify-center text-white text-xs font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
                <span>Profile</span>
            </a>

            <a href="{{ route('notifications.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                          d="M14.25 18.75a2.25 2.25 0 11-4.5 0m9-5.25V10.5a6.75 
                          6.75 0 10-13.5 0v3l-1.5 3h16.5l-1.5-3z"/></svg>
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

    <!-- Bottom section -->
    <div class="p-4 border-t border-gray-200 dark:border-gray-800">
        <!-- Dark mode toggle -->
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

{{-- Spin + fade swap for logo, correct logo per theme --}}
<style>
@keyframes spin-swap {
  0%   { transform: rotate(0deg);   opacity: 1; }
  49%  { opacity: 0; }
  50%  { transform: rotate(180deg); opacity: 0; }
  100% { transform: rotate(360deg); opacity: 1; }
}
.spin-once { animation: spin-swap 0.7s ease-in-out forwards; }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const html   = document.documentElement;
    const logo   = document.getElementById('nav-logo');
    const toggle = document.getElementById('theme-toggle');

    const SRC_LIGHT = "{{ asset('images/LogoDark.png') }}";   // light UI → dark logo
    const SRC_DARK  = "{{ asset('images/LogoWhite.png') }}";  // dark UI → white logo

    // Pick correct logo on load (no flicker)
    const isDarkNow =
        (localStorage.getItem('color-theme') === 'dark') ||
        (!localStorage.getItem('color-theme') && window.matchMedia('(prefers-color-scheme: dark)').matches) ||
        html.classList.contains('dark');

    logo.src = isDarkNow ? SRC_DARK : SRC_LIGHT;
    requestAnimationFrame(() => logo.classList.remove('opacity-0'));

    // Spin + swap when the theme toggle is clicked
    toggle?.addEventListener('click', () => {
        // Start the spin/fade
        logo.classList.add('spin-once');

        // Swap source halfway through animation,
        // after the other script toggles the .dark class
        setTimeout(() => {
            const darkAfterToggle = html.classList.contains('dark');
            logo.src = darkAfterToggle ? SRC_DARK : SRC_LIGHT;
        }, 350);

        // Clean up class at the end
        setTimeout(() => logo.classList.remove('spin-once'), 720);
    });
});
</script>
