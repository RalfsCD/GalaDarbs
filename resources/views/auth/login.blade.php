@extends('layouts.guest')

@section('content')
<main class="min-h-screen flex items-center justify-center px-4 py-10 bg-gray-100 dark:bg-gray-900">

  {{-- Glass panel --}}
  <div class="w-full max-w-md bg-white/55 dark:bg-gray-800/60 backdrop-blur-md
              border border-gray-200 dark:border-gray-700 rounded-3xl p-6 sm:p-8
              shadow-[0_16px_44px_-22px_rgba(0,0,0,0.45)] space-y-6">

    {{-- Logo (switches with theme) --}}
    <div class="flex justify-center relative h-24">
      <img src="{{ asset('images/LogoDark.png') }}" alt="PostPit Logo Light" class="h-24 w-auto block dark:hidden">
      <img src="{{ asset('images/LogoWhite.png') }}" alt="PostPit Logo Dark"  class="h-24 w-auto hidden dark:block">
    </div>

    {{-- Heading --}}
    <div class="text-center space-y-1">
      <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-gray-100">
        Welcome back to <span class="text-gray-700 dark:text-gray-300 animate-shake inline-block">PostPit</span>
      </h1>
      <p class="text-sm text-gray-500 dark:text-gray-400">Log in to your account to continue</p>
    </div>

    {{-- Session status (if any) --}}
    <x-auth-session-status class="mb-2" :status="session('status')" />

    {{-- Login form --}}
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
      @csrf

      {{-- Email --}}
      <div class="space-y-1.5">
        <x-input-label for="email" :value="__('Email')" class="text-gray-900 dark:text-gray-200" />
        <div class="relative">
          <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-gray-400">
            {{-- mail icon --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5v10.5a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6.75Zm0 0L12 12l8.25-5.25"/>
            </svg>
          </span>
          <x-text-input
            id="email"
            name="email"
            type="email"
            :value="old('email')"
            required
            autofocus
            autocomplete="username"
            class="block w-full pl-10 pr-3 py-2.5 rounded-xl
                   text-gray-900 dark:text-gray-100
                   bg-white dark:bg-gray-950/70
                   border border-gray-300 dark:border-gray-700
                   placeholder-gray-400
                   focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600" />
        </div>
        <x-input-error :messages="$errors->get('email')" class="text-red-500" />
      </div>

      {{-- Password --}}
      <div class="space-y-1.5">
        <x-input-label for="password" :value="__('Password')" class="text-gray-900 dark:text-gray-200" />
        <div class="relative">
          <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-gray-400">
            {{-- lock icon --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75A4.5 4.5 0 0 0 12 2.25v0a4.5 4.5 0 0 0-4.5 4.5V10.5M5.25 10.5h13.5a1.5 1.5 0 0 1 1.5 1.5v6.75A2.25 2.25 0 0 1 18 21H6a2.25 2.25 0 0 1-2.25-2.25V12a1.5 1.5 0 0 1 1.5-1.5z"/>
            </svg>
          </span>

          <x-text-input
            id="password"
            name="password"
            type="password"
            required
            autocomplete="current-password"
            class="block w-full pl-10 pr-11 py-2.5 rounded-xl
                   text-gray-900 dark:text-gray-100
                   bg-white dark:bg-gray-950/70
                   border border-gray-300 dark:border-gray-700
                   placeholder-gray-400
                   focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600" />

          {{-- Show / Hide button --}}
          <button type="button" id="toggle-pass"
                  class="absolute inset-y-0 right-2 flex items-center px-1.5 rounded-md
                         text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                  aria-label="Show password">
            {{-- SHOW icon --}}
            <svg id="eye-on" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
            {{-- HIDE icon --}}
            <svg id="eye-off" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
            </svg>
          </button>
        </div>
        <x-input-error :messages="$errors->get('password')" class="text-red-500" />
      </div>

      {{-- Remember me + Login --}}
      <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4 pt-1">
        <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-gray-900 dark:text-gray-200">
          <input id="remember_me" name="remember" type="checkbox"
                 class="rounded border-gray-300 dark:border-gray-600 text-yellow-500 focus:ring-yellow-400" />
          <span>Remember me</span>
        </label>

        <div class="sm:ml-auto">
          <button type="submit"
                  class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full text-sm font-semibold
                         bg-yellow-400 text-gray-900 border border-yellow-300/70 shadow-sm
                         hover:shadow-md hover:-translate-y-0.5 active:bg-yellow-500/90
                         transition focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600">
            {{-- login glyph --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px] -ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
            Log in
          </button>
        </div>
      </div>
    </form>

    {{-- Register link --}}
    <div class="pt-2 text-center">
      <a href="{{ route('register') }}"
         class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full text-sm font-semibold
                bg-white/70 dark:bg-gray-900/60 backdrop-blur
                text-gray-900 dark:text-gray-100 border border-gray-300/70 dark:border-gray-700/80
                shadow-sm hover:shadow-md hover:-translate-y-0.5 transition
                focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600">
        {{-- register glyph --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px] -ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
        </svg>
        Create an account
      </a>
    </div>
  </div>
</main>

{{-- OPAQUE loading overlay (bigger spinner) --}}
<div id="loading-overlay"
     class="fixed inset-0 hidden items-center justify-center z-50 bg-gray-100 dark:bg-gray-900">
  <img src="{{ asset('images/LogoDark.png') }}" alt="Loading Logo" class="h-32 w-auto animate-spin-slow dark:hidden">
  <img src="{{ asset('images/LogoWhite.png') }}" alt="Loading Logo Dark" class="h-32 w-auto animate-spin-slow hidden dark:block">
</div>

{{-- Little animations --}}
<style>
  @keyframes shake { 0%,100%{transform:translateX(0)} 20%{transform:translateX(-2px)} 40%{transform:translateX(2px)} 60%{transform:translateX(-1px)} 80%{transform:translateX(1px)} }
  .animate-shake{ display:inline-block; animation:shake .6s ease-in-out infinite }
  @keyframes spin-slow { from{transform:rotate(0)} to{transform:rotate(360deg)} }
  .animate-spin-slow{ animation:spin-slow 1.3s linear infinite }
</style>

{{-- Scripts --}}
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector('form[action="{{ route('login') }}"]');
    const overlay = document.getElementById("loading-overlay");
    form?.addEventListener("submit", () => {
      overlay.classList.remove("hidden");
      overlay.classList.add("flex");
    });

    // Show/Hide password
    const pass  = document.getElementById("password");
    const btn   = document.getElementById("toggle-pass");
    const eyeOn = document.getElementById("eye-on");
    const eyeOff= document.getElementById("eye-off");

    btn?.addEventListener("click", () => {
      const showing = pass.type === "text";
      pass.type = showing ? "password" : "text";
      eyeOn.classList.toggle("hidden", !showing);
      eyeOff.classList.toggle("hidden", showing);
      btn.setAttribute("aria-label", showing ? "Show password" : "Hide password");
    });
  });
</script>
@endsection
