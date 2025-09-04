@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 space-y-6">

    <h1 class="text-3xl font-bold text-white">Settings</h1>

    @if(session('status'))
        <p class="text-yellow-400">{{ session('status') }}</p>
    @endif

    {{-- Update Profile --}}
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4 mt-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" value="Name" class="text-white"/>
            <x-text-input id="name" name="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full"/>
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-yellow-400"/>
        </div>

        <div>
            <x-input-label for="profile_photo" value="Profile Photo" class="text-white"/>
            <input type="file" name="profile_photo" id="profile_photo" class="mt-1 block w-full text-white"/>
            <x-input-error :messages="$errors->get('profile_photo')" class="mt-2 text-yellow-400"/>
        </div>

        <x-primary-button class="bg-yellow-400 text-black hover:bg-yellow-300">
            Update Profile
        </x-primary-button>
    </form>

    {{-- Delete Account --}}
    <div x-data="{ open: false }" class="mt-6">
        <button @click="open = true" class="bg-yellow-400 hover:bg-yellow-300 text-black px-4 py-2 rounded">
            Delete Account
        </button>

        <div x-show="open" x-transition class="fixed inset-0 flex items-center justify-center z-50">
            <div class="fixed inset-0 bg-black bg-opacity-50" @click="open = false"></div>

            <form method="POST" action="{{ route('profile.destroy') }}" class="bg-black bg-opacity-90 text-white rounded-2xl p-6 relative z-50 max-w-lg w-full space-y-4">
                @csrf
                @method('delete')

                <h2 class="text-2xl font-bold">Are you sure you want to delete your account?</h2>
                <p class="text-gray-300">This action is permanent. Enter your password to confirm.</p>

                <div>
                    <input type="password" name="password" placeholder="Password" class="w-full p-2 rounded text-black"/>
                    @error('password')
                        <p class="text-yellow-400 mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" @click="open = false" class="px-4 py-2 rounded bg-gray-600 hover:bg-gray-500">
                        Cancel
                    </button>

                    <button type="submit" class="px-4 py-2 rounded bg-yellow-400 hover:bg-yellow-300 text-black">
                        Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
