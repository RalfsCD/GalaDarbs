@extends('layouts.guest')

@section('content')
<main class="relative min-h-screen flex items-center justify-center px-4 py-10 sm:py-14
       bg-gradient-to-br from-yellow-50 via-white to-yellow-100
       dark:from-gray-950 dark:via-gray-900 dark:to-gray-900 overflow-hidden">

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

    <div class="flex justify-center mb-4 sm:mb-6">
    <img src="{{ asset('images/LogoDark.png') }}" alt="PostPit" class="h-20 sm:h-24 w-auto block dark:hidden">
    <img src="{{ asset('images/LogoWhite.png') }}" alt="PostPit" class="h-20 sm:h-24 w-auto hidden dark:block">
    </div>

    <h1 class="text-center text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight
         bg-clip-text text-transparent bg-gradient-to-b from-gray-900 to-gray-600
         dark:from-white dark:to-gray-300">
    Welcome to PostPit
    </h1>

    <p class="mt-3 sm:mt-4 text-center text-sm sm:text-base text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
    Connect, create, and explore communities you’ll love. Dive in and find your people.
    </p>

    <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row items-stretch sm:items-center justify-center gap-2.5 sm:gap-3">
    <a href="{{ route('login') }}"
       class="inline-flex items-center justify-center gap-1.5 px-5 sm:px-6 py-2.5 rounded-full
          text-sm sm:text-base font-semibold tracking-tight
          bg-yellow-400 text-gray-900 hover:bg-yellow-500 active:bg-yellow-500/90
          dark:bg-yellow-500 dark:hover:bg-yellow-400 dark:active:bg-yellow-400/90
          border border-yellow-300/70 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all
          focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
         stroke-width="1.5" stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5 -ml-0.5">
      <path stroke-linecap="round" stroke-linejoin="round"
          d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
      </svg>
      Log In
    </a>

    <a href="{{ route('register') }}"
       class="inline-flex items-center justify-center gap-1.5 px-5 sm:px-6 py-2.5 rounded-full
          text-sm sm:text-base font-semibold tracking-tight
          bg-white/80 dark:bg-gray-800/70 text-gray-900 dark:text-gray-100
          border border-gray-300/80 dark:border-gray-700/80
          hover:bg-gray-100 dark:hover:bg-gray-700
          shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all
          focus:outline-none focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-600">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
         stroke-width="1.5" stroke="currentColor" class="w-4 h-4 sm:w-5 sm:h-5 -ml-0.5">
      <path stroke-linecap="round" stroke-linejoin="round"
          d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
      </svg>
      Register
    </a>
    </div>

    <div class="mt-5 sm:mt-7 flex items-center justify-center">
    <button type="button" aria-label="Toggle theme" role="switch" aria-checked="false"
        data-theme-slider
        class="relative inline-flex items-center w-[76px] h-9 rounded-full overflow-hidden
             bg-[#E9EDF3] dark:bg-gray-800
             border border-[#D5DBE3] dark:border-gray-700 transition-colors">

      <svg aria-hidden="true"
         class="pointer-events-none absolute left-2 top-1/2 -translate-y-1/2 w-[18px] h-[18px]
            text-gray-500 dark:text-gray-300 opacity-60 dark:opacity-100 transition-opacity"
         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
         stroke-width="1.5" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round"
          d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/>
      </svg>

      <svg aria-hidden="true"
         class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 w-[18px] h-[18px]
            text-gray-600 dark:text-gray-400 opacity-100 dark:opacity-60 transition-opacity"
         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
         stroke-width="1.5" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round"
          d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z"/>
      </svg>

      <span class="theme-thumb absolute top-[3px] left-[3px] h-[30px] w-[30px] rounded-full
             bg-white dark:bg-[#111827]
             border border-[#D5DBE3] dark:border-gray-700
             shadow-[0_1px_2px_rgba(0,0,0,0.15)]
             transition-transform duration-300 will-change-transform"
        style="transform: translateX(0px);">
      <span class="pointer-events-none absolute inset-0 grid place-items-center">
        <span class="h-2 w-2 rounded-full bg-yellow-400 shadow-[0_0_10px_rgba(250,204,21,0.9)]"></span>
      </span>
      </span>
    </button>
    </div>
  </div>
  </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const html   = document.documentElement;
  const slider = document.querySelector('[data-theme-slider]');
  const THUMB_TX = 40;

  const isDarkPref = () =>
  (localStorage.getItem('color-theme') === 'dark') ||
  (!localStorage.getItem('color-theme') && window.matchMedia('(prefers-color-scheme: dark)').matches) ||
  html.classList.contains('dark');

  const positionThumb = (dark) => {
  const thumb = slider?.querySelector('.theme-thumb');
  if (!thumb) return;
  thumb.style.transform = `translateX(${dark ? THUMB_TX : 0}px)`;
  slider?.setAttribute('aria-checked', dark ? 'true' : 'false');
  };

  const applyTheme = (dark) => {
  if (dark) {
    html.classList.add('dark');
    localStorage.setItem('color-theme', 'dark');
  } else {
    html.classList.remove('dark');
    localStorage.setItem('color-theme', 'light');
  }
  positionThumb(dark);
  };

  applyTheme(isDarkPref());

  slider?.addEventListener('click', () => applyTheme(!html.classList.contains('dark')));
});
</script>
@endsection
