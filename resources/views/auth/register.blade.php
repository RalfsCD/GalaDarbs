@extends('layouts.guest')

@section('content')
<main class="min-h-screen flex flex-col items-center justify-center px-4 bg-gray-100 dark:bg-gray-900">

  <!-- Glass panel -->
  <div class="w-full max-w-md bg-white/55 dark:bg-gray-800/60 backdrop-blur-md border border-gray-200 dark:border-gray-700 rounded-3xl p-8 shadow-sm space-y-6">

    <!-- Logo -->
    <div class="flex justify-center relative h-20">
      <img src="{{ asset('images/LogoDark.png') }}" alt="PostPit logo light" class="h-20 w-auto block dark:hidden">
      <img src="{{ asset('images/LogoWhite.png') }}" alt="PostPit logo dark"  class="h-20 w-auto hidden dark:block">
    </div>

    <!-- Title -->
    <div class="text-center space-y-1">
      <h1 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100">Create your account</h1>
      <p class="text-sm text-gray-500 dark:text-gray-400">Connect & explore communities you’ll love.</p>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
      @csrf

      <!-- Name -->
      <div>
        <x-input-label for="name" :value="__('Name')" class="text-gray-900 dark:text-gray-200"/>
        <div class="relative mt-1">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
            <!-- user icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
          </span>
          <x-text-input id="name"
            class="block w-full pl-10 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400"
            type="text" name="name" :value="old('name')" required autocomplete="name" />
        </div>
        <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-500"/>
      </div>

      <!-- Email -->
      <div>
        <x-input-label for="email" :value="__('Email')" class="text-gray-900 dark:text-gray-200"/>
        <div class="relative mt-1">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
            <!-- mail icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 7.5v9a2.25 2.25 0 0 1-2.25 2.25h-15A2.25 2.25 0 0 1 2.25 16.5v-9A2.25 2.25 0 0 1 4.5 5.25h15A2.25 2.25 0 0 1 21.75 7.5Zm-1.5-.818-7.34 5.115a2.25 2.25 0 0 1-2.82 0L2.75 6.682"/></svg>
          </span>
          <x-text-input id="email"
            class="block w-full pl-10 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400"
            type="email" name="email" :value="old('email')" required autocomplete="username" />
        </div>
        <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500"/>
      </div>

      <!-- Password -->
      <div>
        <x-input-label for="password" :value="__('Password')" class="text-gray-900 dark:text-gray-200"/>
        <div class="relative mt-1">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
            <!-- lock -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V7.875a4.875 4.875 0 1 0-9.75 0V10.5m-.75 0h11.25A2.25 2.25 0 0 1 19.5 12.75v6A2.25 2.25 0 0 1 17.25 21H6.75A2.25 2.25 0 0 1 4.5 18.75v-6A2.25 2.25 0 0 1 6.75 10.5Z"/></svg>
          </span>

          <x-text-input id="password"
            class="block w-full pl-10 pr-10 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400"
            type="password" name="password" required autocomplete="new-password" />

          <!-- eye toggle -->
          <button type="button" id="togglePw"
            class="absolute inset-y-0 right-0 px-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none"
            aria-label="Toggle password visibility">
            <!-- show -->
            <svg id="pw-eye-open" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
            <!-- hide -->
            <svg id="pw-eye-off" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
            </svg>
          </button>
        </div>

        <!-- Strength Bar (thin) -->
        <div class="mt-2 h-1.5 rounded-full bg-gray-200 dark:bg-gray-800 overflow-hidden">
          <div id="pw-bar" class="h-1.5 w-0 rounded-full transition-all duration-300"></div>
        </div>

        <!-- Tips (compact + pretty) -->
        <ul id="pw-tips"
            class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-1.5 text-[11px] leading-tight">
          @php
            $tipBase   = 'flex items-center gap-1.5 text-gray-500 dark:text-gray-400';
            $dotBase   = 'inline-flex items-center justify-center h-3 w-3 rounded-full border border-gray-300 dark:border-gray-600';
            $dotInner  = 'h-1.5 w-1.5 rounded-full bg-gray-300 dark:bg-gray-600';
            $validText = 'text-green-600 dark:text-green-400';
          @endphp

          <li data-rule="length" class="{{ $tipBase }}">
            <span class="{{ $dotBase }}"><span class="{{ $dotInner }}"></span></span>
            At least 8 characters
          </li>
          <li data-rule="case" class="{{ $tipBase }}">
            <span class="{{ $dotBase }}"><span class="{{ $dotInner }}"></span></span>
            Upper &amp; lower case letters
          </li>
          <li data-rule="number" class="{{ $tipBase }}">
            <span class="{{ $dotBase }}"><span class="{{ $dotInner }}"></span></span>
            At least one number
          </li>
          <li data-rule="symbol" class="{{ $tipBase }}">
            <span class="{{ $dotBase }}"><span class="{{ $dotInner }}"></span></span>
            At least one symbol (!@#$…)
          </li>
        </ul>
      </div>

      <!-- Confirm Password -->
      <div>
        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-900 dark:text-gray-200"/>
        <div class="relative mt-1">
          <x-text-input id="password_confirmation"
            class="block w-full pr-10 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400"
            type="password" name="password_confirmation" required autocomplete="new-password" />
          <!-- eye toggle -->
          <button type="button" id="togglePw2"
            class="absolute inset-y-0 right-0 px-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none"
            aria-label="Toggle confirm password visibility">
            <!-- show -->
            <svg id="pw2-eye-open" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
            <!-- hide -->
            <svg id="pw2-eye-off" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
            </svg>
          </button>
        </div>
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-500"/>
        <p id="match-tip" class="mt-1 text-[11px] leading-tight text-gray-500 dark:text-gray-400 hidden">Passwords match ✓</p>
      </div>

      <!-- Footer row -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-1">
        <a href="{{ route('login') }}" class="text-sm underline text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">Already registered?</a>

        <button type="submit"
          class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-yellow-400 text-gray-900 font-semibold border border-yellow-300/70 hover:bg-yellow-500 transition">
          <!-- register icon -->
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 -ml-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
          </svg>
          Register
        </button>
      </div>
    </form>
  </div>
</main>

<!-- Loading overlay (subtle) -->
<div id="loading-overlay" class="fixed inset-0 bg-gray-100/70 dark:bg-gray-900/70 hidden items-center justify-center z-50">
  <img src="{{ asset('images/LogoDark.png') }}" class="h-16 w-auto animate-spin-slow dark:hidden" alt="">
  <img src="{{ asset('images/LogoWhite.png') }}" class="h-16 w-auto animate-spin-slow hidden dark:block" alt="">
</div>

<style>
@keyframes spin-slow { from { transform: rotate(0) } to { transform: rotate(360deg) } }
.animate-spin-slow { animation: spin-slow 1.2s linear infinite }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const pw = document.getElementById('password');
  const pw2 = document.getElementById('password_confirmation');
  const tips = document.getElementById('pw-tips');
  const bar = document.getElementById('pw-bar');
  const matchTip = document.getElementById('match-tip');

  // Toggle eyes
  const togglePw = document.getElementById('togglePw');
  const pwEyeOpen = document.getElementById('pw-eye-open');
  const pwEyeOff  = document.getElementById('pw-eye-off');
  togglePw.addEventListener('click', () => {
    const on = pw.type === 'password';
    pw.type = on ? 'text' : 'password';
    pwEyeOpen.classList.toggle('hidden', !on);
    pwEyeOff.classList.toggle('hidden', on);
  });

  const togglePw2 = document.getElementById('togglePw2');
  const pw2EyeOpen = document.getElementById('pw2-eye-open');
  const pw2EyeOff  = document.getElementById('pw2-eye-off');
  togglePw2.addEventListener('click', () => {
    const on = pw2.type === 'password';
    pw2.type = on ? 'text' : 'password';
    pw2EyeOpen.classList.toggle('hidden', !on);
    pw2EyeOff.classList.toggle('hidden', on);
  });

  function updateTips(validMap) {
    [...tips.querySelectorAll('li')].forEach(li => {
      const ok = !!validMap[li.dataset.rule];
      const dot = li.querySelector('span>span');
      li.classList.toggle('text-green-600', ok);
      li.classList.toggle('dark:text-green-400', ok);
      li.classList.toggle('text-gray-500', !ok);
      li.classList.toggle('dark:text-gray-400', !ok);
      dot.classList.toggle('bg-green-500', ok);
      dot.classList.toggle('dark:bg-green-400', ok);
      dot.classList.toggle('bg-gray-300', !ok);
      dot.classList.toggle('dark:bg-gray-600', !ok);
    });
  }

  function scorePassword(v) {
    const valid = {
      length: v.length >= 8,
      case: /[a-z]/.test(v) && /[A-Z]/.test(v),
      number: /\d/.test(v),
      symbol: /[^\w\s]/.test(v)
    };
    updateTips(valid);

    const score = Object.values(valid).filter(Boolean).length;
    const widths = ['0%','25%','50%','75%','100%'];
    const color  = ['bg-transparent',
                    'bg-red-400',
                    'bg-yellow-400',
                    'bg-emerald-400',
                    'bg-green-500'][score];

    bar.style.width = widths[score];
    bar.className = 'h-1.5 rounded-full transition-all duration-300 ' + color;
  }

  pw.addEventListener('input', e => { scorePassword(e.target.value); checkMatch(); });
  pw2.addEventListener('input', checkMatch);

  function checkMatch() {
    const same = pw.value.length && pw.value === pw2.value;
    matchTip.classList.toggle('hidden', !same);
    matchTip.classList.toggle('text-green-600', same);
    matchTip.classList.toggle('dark:text-green-400', same);
  }

  // Loading overlay on submit
  const form = document.querySelector('form');
  const overlay = document.getElementById('loading-overlay');
  form.addEventListener('submit', () => {
    overlay.classList.remove('hidden');
    overlay.classList.add('flex');
  });

  // Initialize once (empty value)
  scorePassword(pw.value || '');
});
</script>
@endsection
