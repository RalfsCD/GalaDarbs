<nav x-data="{ open: false }" class="bg-white border-b border-gray-300 fixed top-0 left-0 w-full z-50 h-16">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-900" />
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex items-center">
                    @php
                        $links = [
                            ['name' => 'Home', 'route' => 'dashboard'],
                            ['name' => 'Topics', 'route' => 'topics.index'],
                            ['name' => 'Groups', 'route' => 'groups.index'],
                            ['name' => 'News', 'route' => 'news.index'],
                            ['name' => 'About', 'route' => 'about'],
                            ['name' => 'Profile', 'route' => 'profile.show'],
                        ];

                        if(auth()->check() && auth()->user()->isAdmin()) {
                            $links[] = ['name' => 'Admin', 'route' => 'admin.index'];
                        }
                    @endphp

                    @foreach ($links as $link)
                        <x-nav-link 
                            :href="route($link['route'])"
                            :active="request()->routeIs($link['route'])"
                            class="text-gray-900 hover:text-gray-700 border-b-0"
                            :class="request()->routeIs($link['route']) ? 'text-blue-600 border-b-0' : ''"
                        >
                            {{ __($link['name']) }}
                        </x-nav-link>
                    @endforeach

                    <!-- Notifications Button -->
                    <a href="{{ route('notifications.index') }}" 
                       class="relative inline-flex items-center justify-center p-2 rounded-full hover:bg-gray-100 transition">
                        <img src="{{ asset('icons/notification.svg') }}" alt="Notifications" class="w-6 h-6">
                        <!-- Optional: notification badge -->
                        @php
                            $unreadCount = auth()->user()->notifications()->whereNull('read_at')->count();
                        @endphp
                        @if($unreadCount > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="inline-flex items-center m-0 p-0">
                        @csrf
                        <x-nav-link :href="route('logout')" 
                                    onclick="event.preventDefault(); this.closest('form').submit();" 
                                    class="text-red-600 hover:text-red-400 border-b-0 h-full flex items-center">
                            {{ __('Log Out') }}
                        </x-nav-link>
                    </form>
                </div>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" 
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-900 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-700 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" 
         class="hidden sm:hidden bg-white border-t border-gray-300">
        <div class="pt-2 pb-3 space-y-1">
            @foreach ($links as $link)
                <x-responsive-nav-link 
                    :href="route($link['route'])"
                    :active="request()->routeIs($link['route'])"
                    class="text-gray-900 hover:text-gray-700 border-b-0"
                    :class="request()->routeIs($link['route']) ? 'text-blue-600 border-b-0' : ''"
                >
                    {{ __($link['name']) }}
                </x-responsive-nav-link>
            @endforeach

            <!-- Notifications Button Mobile -->
            <a href="{{ route('notifications.index') }}" 
               class="flex items-center p-2 hover:bg-gray-100 transition">
                <img src="{{ asset('icons/notification.svg') }}" alt="Notifications" class="w-6 h-6 mr-2">
                <span>Notifications</span>
                @if($unreadCount > 0)
                    <span class="ml-auto inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                        {{ $unreadCount }}
                    </span>
                @endif
            </a>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" class="inline-flex items-center m-0 p-0">
                @csrf
                <x-responsive-nav-link :href="route('logout')" 
                        onclick="event.preventDefault(); this.closest('form').submit();" 
                        class="text-red-600 hover:text-red-400 border-b-0 h-full flex items-center">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>
