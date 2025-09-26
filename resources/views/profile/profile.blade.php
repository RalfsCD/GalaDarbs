@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 space-y-6">

    {{-- Page Header --}}
    <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 shadow-md flex items-center justify-between">
        <h1 class="text-4xl font-extrabold text-gray-900 dark:text-gray-100">User Profile</h1>
    </div>

    {{-- Profile Information --}}
    <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 shadow-md border border-gray-200 dark:border-gray-700 space-y-6 flex flex-col md:flex-row gap-6 relative">

        <!-- Profile Image -->
        <div class="w-32 h-32 rounded-full overflow-hidden shadow-md">
            <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=ddd&color=555' }}"
                alt="Profile Picture" class="w-full h-full object-cover">
        </div>

        <!-- User Info -->
        <div class="text-center md:text-left flex-1">
            <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 drop-shadow-sm">{{ $user->name }}</p>
            <p class="text-gray-600 dark:text-gray-300 font-semibold capitalize mt-1">{{ $user->role ?? 'user' }}</p>
            <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $user->email }}</p>

            <div class="flex justify-center md:justify-start gap-8 mt-4">
                <div class="flex flex-col items-center">
                    <p class="text-gray-900 dark:text-gray-100 font-bold text-xl">{{ $followers }}</p>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Followers</p>
                </div>
                <div class="flex flex-col items-center">
                    <p class="text-gray-900 dark:text-gray-100 font-bold text-xl">{{ $following }}</p>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Following</p>
                </div>
            </div>
        </div>

        <!-- Settings Icon -->
        <div class="absolute top-6 right-6">
            <a href="{{ route('profile.settings') }}" class="p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-10 w-10 text-gray-900 dark:text-gray-100">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </a>
        </div>
    </div>

    {{-- User Posts Section --}}
    <div class="w-full max-w-7xl p-6 rounded-2xl 
                bg-white dark:bg-gray-800 shadow-md border border-gray-200 dark:border-gray-700">
        <h1 class="text-4xl font-extrabold text-gray-900 dark:text-gray-100">My Posts</h1><br>

        @if($posts->count())
        <div class="flex flex-wrap -mx-3">
            @foreach($posts as $post)
            <a href="{{ route('posts.show', $post) }}" class="w-full md:w-1/2 px-3 mb-6">
                <div class="p-6 rounded-2xl 
                            bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-md hover:shadow-lg transition
                            flex flex-col h-full">

                    <div class="mb-2 flex items-center gap-2 text-sm">
    <span class="text-gray-500 dark:text-gray-400">in</span>
    <span class="font-semibold text-blue-600 dark:text-blue-400">
        {{ $post->group->name }}
    </span>
</div>

                    <div class="flex justify-between items-start">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $post->title }}</h3>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $post->created_at->diffForHumans() }}</span>
                    </div>

                    @if(filled($post->content))
                    <p class="text-gray-600 dark:text-gray-300 mt-2 line-clamp-3">{{ $post->content }}</p>
                    @endif

                    @if($post->media_path)
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $post->media_path) }}"
                            alt="Post Image"
                            class="rounded-lg w-full object-cover max-h-40">
                    </div>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
        @else
            <p class="text-gray-500 dark:text-gray-400">No posts yet.</p>
        @endif
    </div>
</div>
@endsection
