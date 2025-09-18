@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex justify-center p-6">

    <!-- Settings Panel -->
    <div class="w-full max-w-3xl bg-white/50 backdrop-blur-md border border-gray-200 rounded-3xl p-8 space-y-8">

        <!-- Page Header -->
                     <h1 class="text-4xl font-extrabold text-gray-900">Settings</h1>


        @if(session('status'))
            <p class="text-green-600 font-medium">{{ session('status') }}</p>
        @endif

        {{-- Update Profile --}}
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('patch')

            <div>
                <x-input-label for="name" value="Name" class="text-gray-900"/>
                <x-text-input id="name" name="name" value="{{ old('name', $user->name) }}" 
                              class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-300"/>
                <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-500 text-sm"/>
            </div>

            <div>
                <x-input-label for="profile_photo" value="Profile Photo" class="text-gray-900"/>
                <input type="file" name="profile_photo" id="profile_photo" 
                       class="mt-1 block w-full text-gray-700 border border-gray-300 rounded-lg px-3 py-2"/>
                <x-input-error :messages="$errors->get('profile_photo')" class="mt-1 text-red-500 text-sm"/>
            </div>

            <button type="submit" 
                    class="px-4 py-2 rounded-full border-2 border-gray-300 bg-gray-200 text-gray-900 font-bold hover:bg-gray-300 transition">
                Update Profile
            </button>
        </form>

        {{-- Delete Account --}}
        <div x-data="{ open: false }" class="space-y-4">
            <!-- Warning Text -->
            <p class="text-gray-700 font-medium">
                Warning: Deleting your account is permanent and cannot be undone. 
                All your posts, comments, and data will be permanently removed.
            </p>

            <button @click="open = true" 
                    class="px-4 py-2 rounded-full border-2 border-gray-300 bg-gray-200 text-gray-900 font-bold hover:bg-gray-300 transition">
                Delete Account
            </button>

            <!-- Modal -->
            <div x-show="open" x-transition class="fixed inset-0 flex items-center justify-center z-50">
                <!-- Blurry backdrop -->
                <div class="fixed inset-0 bg-white/20 backdrop-blur-md" @click="open = false"></div>

                <!-- Modal Panel -->
                <form method="POST" action="{{ route('profile.destroy') }}" 
                      class="bg-white/70 backdrop-blur-md rounded-2xl p-6 relative z-50 w-full max-w-lg space-y-4 border border-gray-200">
                    @csrf
                    @method('delete')

                    <h2 class="text-2xl font-bold text-gray-900">Confirm Account Deletion</h2>
                    <p class="text-gray-700">Enter your password to confirm deletion.</p>

                    <div>
                        <input type="password" name="password" placeholder="Password" 
                               class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300"/>
                        @error('password')
                            <p class="text-red-500 mt-1 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" @click="open = false" 
                                class="px-4 py-2 rounded-full border-2 border-gray-300 bg-gray-200 text-gray-900 font-bold hover:bg-gray-300 transition">
                            Cancel
                        </button>

                        <button type="submit" 
                                class="px-4 py-2 rounded-full border-2 border-red-500 bg-red-500 text-white font-bold hover:bg-red-600 transition">
                            Delete Account
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
