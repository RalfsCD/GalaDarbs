@extends('layouts.guest')

@section('content')
<main class="relative min-h-[100svh] overflow-hidden bg-[#0A1020] px-4 py-4 sm:px-6 lg:px-8">
  <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top_left,rgba(250,204,21,0.12),transparent_28%),radial-gradient(circle_at_bottom_right,rgba(59,130,246,0.10),transparent_24%),linear-gradient(180deg,#0a1020_0%,#0c1325_100%)]"></div>

  <section class="grid min-h-[100svh] place-items-center">
    <div class="w-full max-w-4xl text-center">
      <div class="flex items-center justify-center gap-3">
        <img src="{{ asset('images/LogoWhite.png') }}" alt="PostPit" class="h-16 w-auto sm:h-20">
        <span class="text-xs uppercase tracking-[0.32em] text-white/55">PostPit</span>
      </div>

      <h1 class="mx-auto mt-8 max-w-[12ch] text-5xl font-black leading-[0.9] tracking-tight text-white sm:text-6xl lg:text-7xl">
        Find your
        <span class="block">space and</span>
        <span class="bg-gradient-to-r from-yellow-300 to-yellow-500 bg-clip-text text-transparent">start talking.</span>
      </h1>

      <p class="mx-auto mt-6 max-w-2xl text-base leading-8 text-white/70 sm:text-lg">
        PostPit is a place to discover groups, follow topics, and join conversations. The page keeps only the essential information and access links.
      </p>

   

      <div class="mt-8 flex flex-wrap justify-center gap-3">
        @auth
          <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-full bg-yellow-400 px-6 py-3 text-base font-semibold text-gray-950 transition hover:bg-yellow-300">
            Dashboard
          </a>
          <a href="{{ route('topics.index') }}" class="inline-flex items-center justify-center rounded-full border border-white/15 px-6 py-3 text-base font-semibold text-white transition hover:bg-white/8">
            Topics
          </a>
        @else
          <a href="{{ route('login') }}" data-loading-trigger="1" class="inline-flex items-center justify-center rounded-full bg-yellow-400 px-6 py-3 text-base font-semibold text-gray-950 transition hover:bg-yellow-300">
            Log In
          </a>
          <a href="{{ route('register') }}" data-loading-trigger="1" class="inline-flex items-center justify-center rounded-full border border-white/15 px-6 py-3 text-base font-semibold text-white transition hover:bg-white/8">
            Register
          </a>
        @endauth
      </div>
    </div>
  </section>
</main>

<div id="loading-overlay" class="fixed inset-0 hidden items-center justify-center z-50 bg-[#0A1020]">
  <img src="{{ asset('images/LogoDark.png') }}" alt="Loading" class="h-24 w-auto animate-spin-slow dark:hidden sm:h-32">
  <img src="{{ asset('images/LogoWhite.png') }}" alt="Loading" class="hidden h-24 w-auto animate-spin-slow dark:block sm:h-32">
</div>

<style>
  @keyframes spin-slow { from { transform: rotate(0) } to { transform: rotate(360deg) } }
  .animate-spin-slow { animation: spin-slow 1.3s linear infinite }
</style>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.getElementById('loading-overlay');
    const showLoader = () => {
      if (!overlay) return;
      overlay.classList.remove('hidden');
      overlay.classList.add('flex');
    };

    document.querySelectorAll('[data-loading-trigger="1"]').forEach((link) => {
      link.addEventListener('click', (event) => {
        if (event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;
        event.preventDefault();
        showLoader();
        window.setTimeout(() => {
          window.location.href = link.href;
        }, 75);
      });
    });
  });
</script>
@endsection
