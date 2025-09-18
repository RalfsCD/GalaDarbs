<nav x-data="{ open: false }" class="bg-white border-b border-gray-300 fixed top-0 left-0 w-full z-50 h-16">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-start items-center h-16 gap-4">

            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-900" />
                </a>
            </div>

            <!-- Nav Links (Desktop) -->
            <div class="hidden sm:flex sm:items-center sm:gap-2">
                @php
                    $links = [
                        ['name' => 'Home', 'route' => 'dashboard', 'icon' => 'home.svg'],
                        ['name' => 'Topics', 'route' => 'topics.index', 'icon' => 'topic.svg'],
                        ['name' => 'Groups', 'route' => 'groups.index', 'icon' => 'group.svg'],
                        ['name' => 'News', 'route' => 'news.index', 'icon' => 'news.svg'],
                        ['name' => 'About', 'route' => 'about', 'icon' => 'about.svg'],
                    ];
                    if(auth()->check() && auth()->user()->isAdmin()) {
                        $links[] = ['name' => 'Admin', 'route' => 'admin.index', 'icon' => 'admin.svg'];
                    }
                    $unreadCount = auth()->user()->notifications()->whereNull('read_at')->count();
                @endphp

                @foreach($links as $link)
                    <a href="{{ route($link['route']) }}" class="flex flex-col items-center gap-1 px-3 py-2 relative text-gray-900 no-underline">
                        <img src="{{ asset('icons/' . $link['icon']) }}" class="w-5 h-5" alt="{{ $link['name'] }}">
                        <span class="text-left text-sm">{{ $link['name'] }}</span>
                        @if(request()->routeIs($link['route']))
                            <span class="absolute bottom-0 h-1 w-6 bg-black rounded-full"></span>
                        @endif
                    </a>
                @endforeach

                <!-- Profile -->
                <a href="{{ route('profile.show') }}" class="flex flex-col items-center gap-1 px-3 py-2 relative text-gray-900 no-underline">
                    @if(auth()->user()->profile_photo_path)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" class="w-6 h-6 rounded-full" alt="Profile">
                    @else
                        <div class="w-6 h-6 rounded-full bg-gray-400 flex items-center justify-center text-white font-bold text-xs">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <span class="text-left text-sm">Profile</span>
                    @if(request()->routeIs('profile.show'))
                        <span class="absolute bottom-0 h-1 w-6 bg-black rounded-full"></span>
                    @endif
                </a>

                <!-- Notifications -->
                <a href="{{ route('notifications.index') }}" class="flex flex-col items-center gap-1 px-3 py-2 relative text-gray-900 no-underline">
                    <img src="{{ asset('icons/notification.svg') }}" class="w-5 h-5" alt="Notifications">
                    <span class="text-left text-sm">Notifications</span>
                    @if($unreadCount > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                            {{ $unreadCount }}
                        </span>
                    @endif
                    @if(request()->routeIs('notifications.index'))
                        <span class="absolute bottom-0 h-1 w-6 bg-black rounded-full"></span>
                    @endif
                </a>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                       class="flex flex-col items-center gap-1 px-3 py-2 relative text-red-600 no-underline">
                        <img src="{{ asset('icons/logout.svg') }}" class="w-5 h-5" alt="Logout">
                        <span class="text-left text-sm">Log Out</span>
                    </a>
                </form>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="sm:hidden flex items-center ml-auto">
                <button @click="open = !open" class="p-2 rounded-md hover:bg-gray-100">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden bg-white border-t border-gray-300">
        <div class="flex flex-col space-y-1 p-2">
            @foreach($links as $link)
                <a href="{{ route($link['route']) }}" class="flex items-center gap-2 px-3 py-2 text-gray-900 no-underline">
                    <img src="{{ asset('icons/' . $link['icon']) }}" class="w-5 h-5">
                    <span>{{ $link['name'] }}</span>
                </a>
            @endforeach

            <a href="{{ route('profile.show') }}" class="flex items-center gap-2 px-3 py-2 text-gray-900 no-underline">
                @if(auth()->user()->profile_photo_path)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" class="w-6 h-6 rounded-full">
                @else
                    <div class="w-6 h-6 rounded-full bg-gray-400 flex items-center justify-center text-white font-bold text-xs">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
                <span>Profile</span>
            </a>

            <a href="{{ route('notifications.index') }}" class="flex items-center gap-2 px-3 py-2 text-gray-900 no-underline">
                <img src="{{ asset('icons/notification.svg') }}" class="w-5 h-5">
                <span>Notifications</span>
                @if($unreadCount > 0)
                    <span class="ml-auto inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                        {{ $unreadCount }}
                    </span>
                @endif
            </a>
            
            <!-- Logout funkcija, izmantojot CSRF -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                   class="flex items-center gap-2 px-3 py-2 text-red-600 no-underline">
                    <img src="{{ asset('icons/logout.svg') }}" class="w-5 h-5">
                    <span>Log Out</span>
                </a>
            </form>
        </div>
    </div>
</nav>
