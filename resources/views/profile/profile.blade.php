@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 py-4 sm:py-6 space-y-4 sm:space-y-6">

    {{-- ===== Hero Header (consistent with Topics/Groups) ===== --}}
    <header
        class="relative overflow-hidden rounded-3xl p-4 sm:p-8
               bg-gradient-to-br from-yellow-100 via-white to-yellow-50
               dark:from-gray-900 dark:via-gray-900/70 dark:to-gray-900
               border border-yellow-200/60 dark:border-gray-800 shadow-xl">
        <div class="relative z-10 flex flex-col md:flex-row md:items-start md:justify-between gap-4">

            <div class="flex items-center gap-3 min-w-0">
                {{-- Avatar --}}
                <div class="shrink-0 w-14 h-14 sm:w-16 sm:h-16 rounded-full overflow-hidden ring-2 ring-yellow-300/60 dark:ring-yellow-600/50 shadow">
                    <img
                        src="{{ $user->profile_photo_path
                                ? asset('storage/' . $user->profile_photo_path)
                                : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=ddd&color=555' }}"
                        alt="{{ $user->name }}"
                        class="w-full h-full object-cover">
                </div>

                <div class="min-w-0">
                    <div class="flex items-center gap-2">
                        <span class="inline-block w-2 h-2 rounded-full bg-yellow-400 shadow-[0_0_10px_rgba(250,204,21,0.85)]"></span>
                        <h1 class="text-xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight
                                   bg-clip-text text-transparent truncate
                                   bg-gradient-to-b from-gray-900 to-gray-600
                                   dark:from-white dark:to-gray-300">
                            {{ $user->name }}
                        </h1>
                    </div>

                    <div class="mt-1 flex flex-wrap items-center gap-2 text-[12px] sm:text-sm">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full
                                     bg-gray-900/5 dark:bg-white/10
                                     text-gray-700 dark:text-gray-200 border border-gray-200/70 dark:border-gray-700/70">
                            {{ ucfirst($user->role ?? 'user') }}
                        </span>
                        <span class="text-gray-500 dark:text-gray-400 truncate">{{ $user->email }}</span>
                    </div>
                </div>
            </div>

            {{-- Settings --}}
            <div class="md:self-start">
                <a href="{{ route('profile.settings') }}"
                   class="inline-flex items-center gap-2 px-3.5 py-2 rounded-full
                          bg-white/60 dark:bg-gray-900/60 backdrop-blur
                          text-gray-900 dark:text-gray-100 text-xs sm:text-sm font-semibold
                          border border-gray-300/70 dark:border-gray-700/80
                          shadow-sm hover:shadow-md
                          hover:bg-yellow-400/15 hover:border-yellow-400/50
                          transition whitespace-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Settings
                </a>
            </div>
        </div>

        {{-- soft decorative blobs --}}
        <div class="pointer-events-none absolute -right-10 -top-10 h-40 w-40 rounded-full blur-3xl bg-yellow-300/30 dark:bg-yellow-500/20"></div>
        <div class="pointer-events-none absolute -left-16 -bottom-12 h-48 w-48 rounded-full blur-3xl bg-orange-300/20 dark:bg-orange-400/10"></div>
    </header>

    {{-- ===== Stats Card ===== --}}
    <section class="rounded-2xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-lg p-4 sm:p-6">
        <div class="flex flex-col xs:flex-row items-stretch xs:items-center gap-3 xs:gap-4">
            <div class="flex-1 grid grid-cols-2 gap-3 sm:gap-4">
                <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-center">
                    <p class="text-2xl font-extrabold text-gray-900 dark:text-gray-100">{{ $followers }}</p>
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Followers</p>
                </div>
                <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-center">
                    <p class="text-2xl font-extrabold text-gray-900 dark:text-gray-100">{{ $following }}</p>
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Following</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== User Posts ===== --}}
    <section class="rounded-2xl bg-white/80 dark:bg-gray-900/70 backdrop-blur border border-gray-200/70 dark:border-gray-800/70 shadow-lg p-4 sm:p-6">
        <div class="flex items-center justify-between gap-3">
            <h2 class="text-lg sm:text-2xl font-extrabold tracking-tight text-gray-900 dark:text-gray-100">My Posts</h2>
        </div>

        @if($posts->count())
            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                @foreach($posts as $post)
                    <a href="{{ route('posts.show', $post) }}" class="group block">
                        <div class="p-4 sm:p-5 rounded-2xl
                                    bg-white dark:bg-gray-800 backdrop-blur-sm
                                    border border-gray-200 dark:border-gray-700
                                    shadow-md hover:shadow-lg transition">

                            {{-- Group pill (prettier “in Group”) --}}
                            <div class="mb-2 flex items-center gap-2 text-[12px] sm:text-sm">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full
                                             bg-yellow-100/80 dark:bg-yellow-500/20
                                             text-yellow-800 dark:text-yellow-100
                                             border border-yellow-300/60 dark:border-yellow-500/30">
                                    {{-- Bookmark-like icon to echo topics/groups styling --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0z"/>
                                    </svg>
                                    <span class="font-semibold truncate max-w-[160px] sm:max-w-none">{{ $post->group->name }}</span>
                                </span>
                                <span class="text-gray-400">•</span>
                                <span class="text-gray-500 dark:text-gray-400">{{ $post->created_at->diffForHumans() }}</span>
                            </div>

                            {{-- Title + content --}}
                            <div class="flex items-start justify-between gap-3">
                                <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-gray-100 break-words">
                                    {{ $post->title }}
                                </h3>
                            </div>

                            @if(filled($post->content))
                                <p class="text-[13.5px] sm:text-sm text-gray-600 dark:text-gray-300 mt-2 line-clamp-3">
                                    {{ $post->content }}
                                </p>
                            @endif

                            {{-- Media preview --}}
                            @if($post->media_path)
                                <div class="mt-3 overflow-hidden rounded-lg">
                                    <img src="{{ asset('storage/' . $post->media_path) }}"
                                         alt="Post Image"
                                         class="w-full object-cover max-h-40 group-hover:scale-[1.01] transition-transform duration-300">
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <p class="mt-3 text-sm sm:text-base text-gray-600 dark:text-gray-400">No posts yet.</p>
        @endif
    </section>
</div>
@endsection
