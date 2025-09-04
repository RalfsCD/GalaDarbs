@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">

    <div class="flex items-center justify-between mb-6">
        <!-- Profile title and info -->
        <div class="flex items-center space-x-6">


            <!-- Profile picture -->
            <div class="w-28 h-28 rounded-full overflow-hidden border-2 border-yellow-400">
                <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=000&color=fff' }}" 
                     alt="Profile Picture" class="w-full h-full object-cover">
            </div>

            <!-- Name and stats -->
            <div>
                <p class="text-white text-2xl font-semibold">{{ $user->name }}</p>
                <p class="text-gray-300">{{ $user->email }}</p>

                <div class="flex space-x-6 mt-1">
                    <div>
                        <p class="text-white font-bold">{{ $followers }}</p>
                        <p class="text-gray-400 text-sm">Followers</p>
                    </div>
                    <div>
                        <p class="text-white font-bold">{{ $following }}</p>
                        <p class="text-gray-400 text-sm">Following</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Gear Icon -->
        <a href="{{ route('profile.settings') }}">
            <img src="{{ asset('images/settings.svg') }}" alt="Settings" class="w-10 h-10"/>
        </a>
    </div>

</div>
@endsection
