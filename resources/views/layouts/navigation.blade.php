<nav x-data="{ open: false }" class="bg-black border-b border-gray-700 fixed top-0 left-0 w-full z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-white" />
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex items-center">
                    @php
                        $links = [
                            ['name' => 'Home', 'route' => 'dashboard'],
                            ['name' => 'Topics', 'route' => 'topics'],
                            ['name' => 'Groups', 'route' => 'groups'],
                            ['name' => 'News', 'route' => 'news.index'],
                            ['name' => 'About', 'route' => 'about'],
                            ['name' => 'Profile', 'route' => 'profile.show'],
                        ];
                    @endphp

                    @foreach ($links as $link)
                        <x-nav-link 
                            :href="route($link['route'])"
                            :active="request()->routeIs($link['route'])"
                            class="text-white hover:text-gray-300 border-b-0"
                            :class="request()->routeIs($link['route']) ? 'text-yellow-400 border-b-0' : ''"
                        >
                            {{ __($link['name']) }}
                        </x-nav-link>
                    @endforeach

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="inline-flex items-center m-0 p-0">
                        @csrf
                        <x-nav-link :href="route('logout')" 
                                    onclick="event.preventDefault(); this.closest('form').submit();" 
                                    class="text-yellow-400 hover:text-yellow-300 border-b-0 h-full flex items-center">
                            {{ __('Log Out') }}
                        </x-nav-link>
                    </form>
                </div>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-300 hover:text-white hover:bg-gray-800 focus:outline-none focus:bg-gray-800 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-black border-t border-gray-700">
        <div class="pt-2 pb-3 space-y-1">
            @foreach ($links as $link)
                <x-responsive-nav-link 
                    :href="route($link['route'])"
                    :active="request()->routeIs($link['route'])"
                    class="text-white hover:text-gray-300 border-b-0"
                    :class="request()->routeIs($link['route']) ? 'text-yellow-400 border-b-0' : ''"
                >
                    {{ __($link['name']) }}
                </x-responsive-nav-link>
            @endforeach

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" class="inline-flex items-center m-0 p-0">
                @csrf
                <x-responsive-nav-link :href="route('logout')" 
                        onclick="event.preventDefault(); this.closest('form').submit();" 
                        class="text-yellow-400 hover:text-yellow-300 border-b-0 h-full flex items-center">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>
