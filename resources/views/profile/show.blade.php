@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <h1 class="text-4xl font-extrabold text-white mb-6">My Profile</h1>

    <div class="flex items-center space-x-6">
        <div class="w-28 h-28 rounded-full overflow-hidden border-2 border-yellow-400">
            <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=000&color=fff' }}"
                alt="Profile Picture"
                class="w-full h-full object-cover">
        </div>

        <div>
            <p class="text-white text-2xl font-semibold">{{ $user->name }}</p>
            <div class="flex space-x-6 mt-1">
                <span><strong class="text-white">{{ $followersCount }}</strong> followers</span>
                <span><strong class="text-white">{{ $followingCount }}</strong> following</span>
            </div>

            <a href="{{ route('profile.settings') }}" class="mt-4 inline-block px-4 py-2 bg-yellow-400 text-black rounded hover:bg-yellow-300">
                Settings
            </a>
        </div>
    </div>
</div>
@endsection