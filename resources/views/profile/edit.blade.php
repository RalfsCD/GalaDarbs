@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 py-4 sm:py-6 space-y-4 sm:space-y-6">

    {{-- Hero Header (matches Topics/Groups style) --}}
    <header
        class="relative overflow-hidden rounded-3xl p-6 sm:p-8
               bg-gradient-to-br from-yellow-100 via-white to-yellow-50
               dark:from-gray-900 dark:via-gray-900/70 dark:to-gray-900
               border border-yellow-200/60 dark:border-gray-800 shadow-xl">
        <div class="relative z-10 flex flex-col md:flex-row md:items-start md:justify-between gap-4">
            <div class="max-w-2xl">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight
                           bg-clip-text text-transparent
                           bg-gradient-to-b from-gray-900 to-gray-600
                           dark:from-white dark:to-gray-300">
                    Profile
                </h1>
                <p class="mt-2 text-sm sm:text-base text-gray-700 dark:text-gray-300">
                    Manage your account details, password, and account deletion settings.
                </p>
            </div>

            {{-- Optional badge for visual balance --}}
            <div class="hidden sm:block md:self-start">
                <div class="rounded-2xl px-3 py-1.5 text-[11px] font-bold tracking-wide
                            bg-yellow-400/20 text-yellow-900 dark:bg-yellow-500/20 dark:text-yellow-100
                            border border-yellow-300/40 dark:border-yellow-500/40">
                    Account Settings
                </div>
            </div>
        </div>

        {{-- soft decorative blobs --}}
        <div class="pointer-events-none absolute -right-10 -top-10 h-40 w-40 rounded-full blur-3xl bg-yellow-300/30 dark:bg-yellow-500/20"></div>
        <div class="pointer-events-none absolute -left-16 -bottom-12 h-48 w-48 rounded-full blur-3xl bg-orange-300/20 dark:bg-orange-400/10"></div>
    </header>

    {{-- Forms container --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">

        {{-- Update Profile Information --}}
        <section class="rounded-2xl bg-white/80 dark:bg-gray-900/70 backdrop-blur
                        border border-gray-200/70 dark:border-gray-800/70 shadow-lg p-4 sm:p-6">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100">Profile Information</h2>
                <span class="hidden sm:inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold
                             bg-yellow-400/20 text-yellow-900 dark:bg-yellow-500/20 dark:text-yellow-100
                             border border-yellow-300/40 dark:border-yellow-500/40">
                    Basic
                </span>
            </div>
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </section>

        {{-- Update Password --}}
        <section class="rounded-2xl bg-white/80 dark:bg-gray-900/70 backdrop-blur
                        border border-gray-200/70 dark:border-gray-800/70 shadow-lg p-4 sm:p-6">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100">Update Password</h2>
                <span class="hidden sm:inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold
                             bg-yellow-400/20 text-yellow-900 dark:bg-yellow-500/20 dark:text-yellow-100
                             border border-yellow-300/40 dark:border-yellow-500/40">
                    Security
                </span>
            </div>
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </section>

        {{-- Delete Account (full width on lg for emphasis) --}}
        <section class="lg:col-span-2 rounded-2xl bg-white/80 dark:bg-gray-900/70 backdrop-blur
                        border border-gray-200/70 dark:border-gray-800/70 shadow-lg p-4 sm:p-6">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-gray-100">Delete Account</h2>
                <span class="hidden sm:inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold
                             bg-red-500/15 text-red-700 dark:text-red-100
                             border border-red-400/40 dark:border-red-600/40">
                    Danger Zone
                </span>
            </div>
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </section>
    </div>

</div>
@endsection
