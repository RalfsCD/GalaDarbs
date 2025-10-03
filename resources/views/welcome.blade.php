@extends('layouts.guest')

@section('content')
<main class="relative min-h-screen flex items-center justify-center px-4 py-10 sm:py-14
             bg-gradient-to-br from-yellow-50 via-white to-yellow-100
             dark:from-gray-950 dark:via-gray-900 dark:to-gray-900 overflow-hidden">

  {{-- Ambient blobs --}}
  <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10">
    <div class="absolute -top-24 -right-24 h-[26rem] w-[26rem] rounded-full blur-3xl
                bg-gradient-to-br from-yellow-300/40 to-orange-400/30
                dark:from-yellow-500/25 dark:to-orange-400/20"></div>
    <div class="absolute -bottom-28 -left-20 h-[30rem] w-[30rem] rounded-full blur-3xl
                bg-gradient-to-tr from-white/60 to-yellow-200/40
                dark:from-gray-800/40 dark:to-yellow-500/20"></div>
  </div>

  <section class="w-full max-w-3xl">
    <div class="rounded-3xl border border-yellow-200/70 dark:border-gray-800/70
                bg-white/80 dark:bg-gray-900/70 backdrop-blur
                shadow-[0_20px_60px_-24px_rgba(0,0,0,0.45)] p-6 sm:p-10">

      {{-- Logo (auto theme) --}}
      <div class="flex justify-center mb-4 sm:mb-6">
        <img src="{{ asset('images/LogoDark.png') }}" alt="PostPit" class="h-20 sm:h-24 w-auto block dark:hidden">
        <img src="{{ asset('images/LogoWhite.png') }}" alt="PostPit" class="h-20 sm:h-24 w-auto hidden dark:block">
      </div>

      {{-- Heading --}}
      <h1 class="text-center text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight
                 bg-clip-text text-transparent bg-gradient-to-b from-gray-900 to-gray-600
                 dark:from-white dark:to-gray-300">
        Welcome to PostPit
      </h1>

      {{-- Subheading --}}
      <p class="mt-3 sm:mt-4 text-center text-sm sm:text-base text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
        Connect, create, and explore communities you’ll love. Dive in and find your people.
      </p>

      {{-- CTAs --}}
      <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row items-stretch sm:items-center justify-center gap-2.5 sm:gap-3">
        {{-- Log In --}}
        <a href="{{ route('login') }}"
           class="inline-flex items-center justify-center gap-1.5 px-5 sm:px-6 py-2.5 rounded-full
                  text-sm sm:text-base font-semibold tracking-tight
                  bg-yellow-400 text-gray-900 hover:bg-yellow-500 active:bg-yellow-500/90
                  dark:bg-yellow-500 dark:hover:bg-yellow-400 dark:active:bg-yellow-400/90
                  border border-yellow-300/70 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all
                  focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600">
          {{-- Login icon (user circle) --}}
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
               stroke-width="1.5" stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5 -ml-0.5">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
          </svg>
          Log In
        </a>

        {{-- Register --}}
        <a href="{{ route('register') }}"
           class="inline-flex items-center justify-center gap-1.5 px-5 sm:px-6 py-2.5 rounded-full
                  text-sm sm:text-base font-semibold tracking-tight
                  bg-white/80 dark:bg-gray-800/70 text-gray-900 dark:text-gray-100
                  border border-gray-300/80 dark:border-gray-700/80
                  hover:bg-gray-100 dark:hover:bg-gray-700
                  shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all
                  focus:outline-none focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-600">
          {{-- Register icon (add user) --}}
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
               stroke-width="1.5" stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5 -ml-0.5">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
          </svg>
          Register
        </a>
      </div>

      {{-- Theme toggle with your icons --}}
      <div class="mt-5 sm:mt-7 flex items-center justify-center">
        <button id="theme-toggle" type="button"
                class="inline-flex items-center gap-2 px-4 sm:px-5 py-2.5 rounded-full
                       bg-white/80 dark:bg-gray-800/70 text-gray-700 dark:text-gray-300
                       border border-gray-300 dark:border-gray-700
                       hover:bg-gray-100 dark:hover:bg-gray-700 transition
                       focus:outline-none focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-600">
          {{-- Sun = light icon --}}
          <svg id="theme-toggle-light-icon" class="w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg"
               fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
          </svg>
          {{-- Moon = dark icon --}}
          <svg id="theme-toggle-dark-icon" class="w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg"
               fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
          </svg>
          <span>Toggle Theme</span>
        </button>
      </div>
    </div>
  </section>
</main>

{{-- Theme toggle script --}}
<script>
  const themeToggleBtn = document.getElementById('theme-toggle');
  const darkIcon = document.getElementById('theme-toggle-dark-icon');   // moon
  const lightIcon = document.getElementById('theme-toggle-light-icon'); // sun

  // Initial state
  if (localStorage.getItem('color-theme') === 'dark' ||
      (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark');
    darkIcon.classList.add('hidden');     // show sun to switch to light
    lightIcon.classList.remove('hidden');
  } else {
    document.documentElement.classList.remove('dark');
    lightIcon.classList.add('hidden');    // show moon to switch to dark
    darkIcon.classList.remove('hidden');
  }

  themeToggleBtn.addEventListener('click', () => {
    darkIcon.classList.toggle('hidden');
    lightIcon.classList.toggle('hidden');
    if (document.documentElement.classList.contains('dark')) {
      document.documentElement.classList.remove('dark');
      localStorage.setItem('color-theme', 'light');
    } else {
      document.documentElement.classList.add('dark');
      localStorage.setItem('color-theme', 'dark');
    }
  });
</script>
@endsection
