@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex justify-center items-start p-6">

    <!-- Glass panel container -->
    <div class="relative w-full max-w-4xl p-8 rounded-3xl 
                bg-white/50 backdrop-blur-md border border-gray-200 shadow-sm
                overflow-hidden">

        <!-- Subtle gray gradient for depth -->
        <div class="absolute inset-0 bg-gradient-to-tr from-gray-200/20 via-white/10 to-gray-100/10 pointer-events-none rounded-3xl"></div>

        <div class="relative flex flex-col md:flex-row items-center md:items-start gap-6">

            <!-- Profile picture -->
            <div class="w-32 h-32 rounded-full overflow-hidden shadow-md">
                <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=ddd&color=555' }}" 
                     alt="Profile Picture" class="w-full h-full object-cover">
            </div>

            <!-- Name, role, and stats -->
            <div class="text-center md:text-left flex-1">
                <p class="text-3xl font-bold text-gray-900 drop-shadow-sm">{{ $user->name }}</p>
                <p class="text-gray-600 font-semibold capitalize mt-1">{{ $user->role ?? 'user' }}</p>
                <p class="text-gray-500 mt-1">{{ $user->email }}</p>

                <div class="flex justify-center md:justify-start gap-8 mt-4">
                    <div class="flex flex-col items-center">
                        <p class="text-gray-900 font-bold text-xl">{{ $followers }}</p>
                        <p class="text-gray-600 text-sm">Followers</p>
                    </div>
                    <div class="flex flex-col items-center">
                        <p class="text-gray-900 font-bold text-xl">{{ $following }}</p>
                        <p class="text-gray-600 text-sm">Following</p>
                    </div>
                </div>
            </div>

            <!-- Settings Icon -->
            <div class="absolute top-6 right-6">
                <a href="{{ route('profile.settings') }}" 
                   class="p-2 rounded-full ">
                    <img src="{{ asset('icons/settings.svg') }}" alt="Settings" class="w-10 h-10">
                </a>
            </div>

        </div>

    </div>
</div>
@endsection
