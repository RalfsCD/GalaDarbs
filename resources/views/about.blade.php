@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 py-4 sm:py-6 space-y-4 sm:space-y-6">

    {{-- ===== Hero / Page Header (aligned with topics/groups pages) ===== --}}
    <section
        class="relative overflow-hidden rounded-3xl p-6 sm:p-8
               bg-gradient-to-br from-yellow-100 via-white to-yellow-50
               dark:from-gray-900 dark:via-gray-900/70 dark:to-gray-900
               border border-yellow-200/60 dark:border-gray-800 shadow-xl">
        <div class="relative z-10 flex flex-col md:flex-row md:items-start md:justify-between gap-3 sm:gap-4">
            <div class="max-w-2xl">
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight
                           bg-clip-text text-transparent
                           bg-gradient-to-b from-gray-900 to-gray-600
                           dark:from-white dark:to-gray-300">
                    About PostPit
                </h1>
                <p class="mt-2 text-sm sm:text-base text-gray-700 dark:text-gray-300">
                    A welcoming place to <span class="font-semibold text-gray-900 dark:text-gray-100">share ideas, discover communities,</span>
                    and have meaningful conversations — without the noise.
                </p>
            </div>

            <div class="hidden sm:flex items-center">
                <div class="rounded-2xl px-3 py-1.5 text-[11px] font-bold tracking-wide
                            bg-yellow-400/20 text-yellow-900 dark:bg-yellow-500/20 dark:text-yellow-100
                            border border-yellow-300/40 dark:border-yellow-500/40">
                    Community-Driven
                </div>
            </div>
        </div>

        {{-- soft decorative blobs (match other pages) --}}
        <div class="pointer-events-none absolute -right-10 -top-10 h-40 w-40 rounded-full blur-3xl bg-yellow-300/30 dark:bg-yellow-500/20"></div>
        <div class="pointer-events-none absolute -left-16 -bottom-12 h-48 w-48 rounded-full blur-3xl bg-orange-300/20 dark:bg-orange-400/10"></div>
    </section>

    {{-- ===== What is PostPit ===== --}}
    <section class="p-4 sm:p-6 rounded-2xl bg-white/80 dark:bg-gray-900/70 backdrop-blur
                    border border-gray-200/70 dark:border-gray-800/70 shadow-lg space-y-2">
        <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100">What is PostPit?</h2>
        <p class="text-sm sm:text-base text-gray-700 dark:text-gray-300 leading-relaxed">
            <span class="font-semibold text-gray-900 dark:text-gray-100">PostPit</span> is a social platform built around
            <em>topics and groups</em>. Create or join communities, post your thoughts, share links and images, and jump
            into conversations that matter to you. Whether you’re into breaking news, deep-dive discussions, or bite-sized
            memes — there’s a corner of the pit with your name on it.
        </p>
    </section>

    {{-- ===== Key Benefits / Features (card grid, compact) ===== --}}
    <section class="p-4 sm:p-6 rounded-2xl bg-white/80 dark:bg-gray-900/70 backdrop-blur
                    border border-gray-200/70 dark:border-gray-800/70 shadow-lg">
        <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100 mb-3">Why you’ll love it</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
            <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-2">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-yellow-400/20 text-yellow-700 dark:text-yellow-200">💬</span>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">Focused discussions</h3>
                </div>
                <p class="mt-1.5 text-sm text-gray-700 dark:text-gray-300">Topic-based groups keep conversations relevant and easy to follow.</p>
            </div>

            <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-2">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-yellow-400/20 text-yellow-700 dark:text-yellow-200">⚡</span>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">Light, fast, and friendly</h3>
                </div>
                <p class="mt-1.5 text-sm text-gray-700 dark:text-gray-300">Smooth posting, quick interactions, and an interface that stays out of your way.</p>
            </div>

            <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-2">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-yellow-400/20 text-yellow-700 dark:text-yellow-200">🌱</span>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">Built to grow communities</h3>
                </div>
                <p class="mt-1.5 text-sm text-gray-700 dark:text-gray-300">Start small, invite friends, and scale your group with simple tools.</p>
            </div>

            <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-2">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-yellow-400/20 text-yellow-700 dark:text-yellow-200">🖼️</span>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">Rich media posts</h3>
                </div>
                <p class="mt-1.5 text-sm text-gray-700 dark:text-gray-300">Share images and links beautifully — instant previews, clean reading view.</p>
            </div>

            <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-2">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-yellow-400/20 text-yellow-700 dark:text-yellow-200">🔔</span>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">Stay in the loop</h3>
                </div>
                <p class="mt-1.5 text-sm text-gray-700 dark:text-gray-300">Likes, comments, and group updates keep you connected — never overwhelmed.</p>
            </div>

            <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-2">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-yellow-400/20 text-yellow-700 dark:text-yellow-200">🛡️</span>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">Safety by design</h3>
                </div>
                <p class="mt-1.5 text-sm text-gray-700 dark:text-gray-300">Report tools, clear rules, and active moderation keep the pit respectful.</p>
            </div>
        </div>
    </section>

    {{-- ===== How it works (ordered cards) ===== --}}
    <section class="p-4 sm:p-6 rounded-2xl bg-white/80 dark:bg-gray-900/70 backdrop-blur
                    border border-gray-200/70 dark:border-gray-800/70 shadow-lg">
        <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100 mb-3">How it works</h2>
        <ol class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 list-decimal list-inside">
            <li class="p-4 rounded-xl bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700">
                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">Find your groups</p>
                <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">Browse topics you care about — or create a new one.</p>
            </li>
            <li class="p-4 rounded-xl bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700">
                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">Share something</p>
                <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">Post thoughts, questions, links, or images in seconds.</p>
            </li>
            <li class="p-4 rounded-xl bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700">
                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">Join the conversation</p>
                <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">Like and comment to keep great threads alive.</p>
            </li>
            <li class="p-4 rounded-xl bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700">
                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">Grow together</p>
                <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">Invite friends and shape the culture of your community.</p>
            </li>
        </ol>
    </section>

    {{-- ===== Why & Values Accordions (compact headings) ===== --}}
    <section class="grid lg:grid-cols-2 gap-4 sm:gap-6">
        <div class="p-4 sm:p-6 rounded-2xl bg-white/80 dark:bg-gray-900/70 backdrop-blur
                    border border-gray-200/70 dark:border-gray-800/70 shadow-lg">
            <section x-data="{ open: true }" class="space-y-2">
                <button @click="open = !open"
                        class="flex items-center justify-between w-full text-base sm:text-lg font-bold px-2.5 py-2 rounded
                               text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <span>Why PostPit?</span>
                    <svg :class="{'rotate-180': open}" class="h-4 w-4 sm:h-5 sm:w-5 text-gray-900 dark:text-gray-100 transition-transform duration-200"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <ul x-show="open" x-transition class="list-disc pl-5 space-y-1.5 text-sm text-gray-700 dark:text-gray-300">
                    <li>Communities designed around interests — not algorithms.</li>
                    <li>Clean design with thoughtful motion that respects your time.</li>
                    <li>Simple tools for creators and mods to set the tone and grow.</li>
                </ul>
            </section>
        </div>

        <div class="p-4 sm:p-6 rounded-2xl bg-white/80 dark:bg-gray-900/70 backdrop-blur
                    border border-gray-200/70 dark:border-gray-800/70 shadow-lg">
            <section x-data="{ open: true }" class="space-y-2">
                <button @click="open = !open"
                        class="flex items-center justify-between w-full text-base sm:text-lg font-bold px-2.5 py-2 rounded
                               text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    <span>Our Values</span>
                    <svg :class="{'rotate-180': open}" class="h-4 w-4 sm:h-5 sm:w-5 text-gray-900 dark:text-gray-100 transition-transform duration-200"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <ul x-show="open" x-transition class="space-y-2 pl-5 text-sm text-gray-700 dark:text-gray-300">
                    <li><span class="font-semibold text-gray-900 dark:text-gray-100">Community First</span> — People over metrics. We optimize for great conversations.</li>
                    <li><span class="font-semibold text-gray-900 dark:text-gray-100">Respect & Inclusion</span> — Every voice deserves a fair hearing; harassment isn’t welcome.</li>
                    <li><span class="font-semibold text-gray-900 dark:text-gray-100">Curiosity & Play</span> — From deep dives to lighthearted memes, explore freely.</li>
                </ul>
            </section>
        </div>
    </section>

    {{-- ===== Safety & Moderation ===== --}}
    <section class="p-4 sm:p-6 rounded-2xl bg-white/80 dark:bg-gray-900/70 backdrop-blur
                    border border-gray-200/70 dark:border-gray-800/70 shadow-lg">
        <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">Safety & moderation</h2>
        <p class="text-sm sm:text-base text-gray-700 dark:text-gray-300">
            We want PostPit to feel friendly and safe. If something crosses the line, you can report it with one tap.
            Moderators and admins review reports, and groups set clear rules so expectations stay transparent.
        </p>
        <ul class="mt-3 grid sm:grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-3 text-sm text-gray-700 dark:text-gray-300">
            <li class="p-3 rounded-lg bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700">• Report tools on every post</li>
            <li class="p-3 rounded-lg bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700">• Group rules & norms visible</li>
            <li class="p-3 rounded-lg bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700">• Active moderation workflow</li>
            <li class="p-3 rounded-lg bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700">• Clear escalation paths</li>
        </ul>
    </section>

    
<section class="p-4 sm:p-6 rounded-2xl bg-white/80 dark:bg-gray-900/70 backdrop-blur
                border border-gray-200/70 dark:border-gray-800/70 shadow-lg">
    <div class="flex flex-col gap-3 sm:gap-4">
        <p class="text-sm sm:text-base text-gray-900 dark:text-gray-100">
            Ready to explore? <span class="font-semibold">Find a community that fits you.</span>
        </p>

        {{-- Always horizontal; each button flexes to half width even on mobile --}}
        <div class="flex w-full items-stretch gap-2 sm:gap-3">
            <a href="{{ route('groups.index') }}"
               class="flex-1 min-w-0 inline-flex items-center justify-center gap-2
                      px-4 sm:px-5 py-3 sm:py-3.5 rounded-full text-base sm:text-lg font-semibold
                      bg-white/70 dark:bg-gray-900/70 backdrop-blur
                      text-gray-900 dark:text-gray-100
                      border border-gray-300/70 dark:border-gray-700/80
                      shadow-md hover:shadow-lg
                      hover:bg-yellow-50/80 dark:hover:bg-gray-800/80
                      focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600 transition">
                {{-- Groups icon (provided) --}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                     class="h-5 w-5 sm:h-6 sm:w-6 opacity-90">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
                Explore Groups
            </a>

            <a href="{{ route('topics.index') }}"
               class="flex-1 min-w-0 inline-flex items-center justify-center gap-2
                      px-4 sm:px-5 py-3 sm:py-3.5 rounded-full text-base sm:text-lg font-semibold
                      bg-gradient-to-r from-yellow-400 to-amber-400
                      text-gray-900
                      hover:from-yellow-500 hover:to-amber-500 active:from-yellow-500 active:to-amber-500
                      dark:from-yellow-500 dark:to-amber-500
                      dark:hover:from-yellow-400 dark:hover:to-amber-400
                      border border-yellow-300/70 shadow-md hover:shadow-lg
                      focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:focus:ring-yellow-600 transition">
                {{-- Topics icon (provided) --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 opacity-90"
                     fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0z"/>
                </svg>
                Explore Topics
            </a>
        </div>
    </div>
</section>
</div>
@endsection
