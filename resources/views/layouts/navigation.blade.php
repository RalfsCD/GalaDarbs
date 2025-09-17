<nav x-data="{ open: false }" class="bg-white border-b border-gray-300 fixed top-0 left-0 w-full z-50 h-16">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-900" />
                </a>
            </div>

            <!-- Navigation Links Desktop -->
            <div class="hidden sm:flex sm:items-center sm:space-x-4">
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

                @foreach ($links as $link)
                    <x-nav-link 
                        :href="route($link['route'])"
                        :active="request()->routeIs($link['route'])"
                        class="flex items-center gap-2 text-gray-900 hover:text-gray-700 border-b-0"
                        :class="request()->routeIs($link['route']) ? 'border-b-2 border-black' : ''"
                    >
                        <img src="{{ asset('icons/' . $link['icon']) }}" class="w-5 h-5" alt="{{ $link['name'] }} Icon">
                        <span>{{ $link['name'] }}</span>
                    </x-nav-link>
                @endforeach

                <!-- Profile -->
                <x-nav-link :href="route('profile.show')"
                            class="flex items-center gap-2 text-gray-900 hover:text-gray-700"
                            :class="request()->routeIs('profile.show') ? 'border-b-2 border-black' : ''">
                    @if(auth()->user()->profile_photo_path)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" class="w-5 h-5 rounded-full" alt="Profile">
                    @else
                        <div class="w-5 h-5 rounded-full bg-gray-400 flex items-center justify-center text-white text-xs font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <span>Profile</span>
                </x-nav-link>

                <!-- Notifications -->
                <x-nav-link href="{{ route('notifications.index') }}" 
                            class="flex items-center gap-2 text-gray-900 hover:text-gray-700"
                            :class="request()->routeIs('notifications.index') ? 'border-b-2 border-black' : ''"
                >
                    <img src="{{ asset('icons/notification.svg') }}" class="w-5 h-5" alt="Notifications">
                    <span>Notifications</span>
                    @if($unreadCount > 0)
                        <span class="ml-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </x-nav-link>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}" class="inline-flex items-center m-0 p-0">
                    @csrf
                    <x-nav-link :href="route('logout')" 
                                onclick="event.preventDefault(); this.closest('form').submit();" 
                                class="flex items-center gap-2 text-red-600 hover:text-red-400 border-b-0"
                    >
                        <img src="{{ asset('icons/logout.svg') }}" class="w-5 h-5" alt="Logout Icon">
                        <span>Log Out</span>
                    </x-nav-link>
                </form>
            </div>

            <!-- Hamburger Mobile -->
            <div class="sm:hidden flex items-center -mr-2">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded text-gray-900 hover:text-gray-700 hover:bg-gray-100 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-300">
        <div class="pt-2 pb-3 space-y-1">
            @foreach ($links as $link)
                <x-responsive-nav-link 
                    :href="route($link['route'])"
                    :active="request()->routeIs($link['route'])"
                    class="flex items-center gap-2 text-gray-900 hover:text-gray-700 border-b-0"
                    :class="request()->routeIs($link['route']) ? 'border-b-2 border-black' : ''"
                >
                    <img src="{{ asset('icons/' . $link['icon']) }}" class="w-5 h-5" alt="{{ $link['name'] }} Icon">
                    <span>{{ $link['name'] }}</span>
                </x-responsive-nav-link>
            @endforeach

            <!-- Profile Mobile -->
            <x-responsive-nav-link :href="route('profile.show')" 
                                   class="flex items-center gap-2 text-gray-900 hover:text-gray-700"
                                   :class="request()->routeIs('profile.show') ? 'border-b-2 border-black' : ''">
                @if(auth()->user()->profile_photo_path)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" class="w-5 h-5 rounded-full" alt="Profile">
                @else
                    <div class="w-5 h-5 rounded-full bg-gray-400 flex items-center justify-center text-white text-xs font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
                <span>Profile</span>
            </x-responsive-nav-link>

            <!-- Notifications Mobile -->
            <x-responsive-nav-link href="{{ route('notifications.index') }}" 
                                   class="flex items-center gap-2 text-gray-900 hover:text-gray-700"
                                   :class="request()->routeIs('notifications.index') ? 'border-b-2 border-black' : ''">
                <img src="{{ asset('icons/notification.svg') }}" class="w-5 h-5" alt="Notifications">
                <span>Notifications</span>
                @if($unreadCount > 0)
                    <span class="ml-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                        {{ $unreadCount }}
                    </span>
                @endif
            </x-responsive-nav-link>

            <!-- Logout Mobile -->
            <form method="POST" action="{{ route('logout') }}" class="inline-flex items-center m-0 p-0 w-full">
                @csrf
                <x-responsive-nav-link :href="route('logout')" 
                                       onclick="event.preventDefault(); this.closest('form').submit();" 
                                       class="flex items-center gap-2 text-red-600 hover:text-red-400 border-b-0 w-full"
                >
                    <img src="{{ asset('icons/logout.svg') }}" class="w-5 h-5" alt="Logout Icon">
                    <span>Log Out</span>
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>
