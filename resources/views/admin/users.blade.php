@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 space-y-6">

    {{-- Page Header Card --}}
    <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 shadow-md flex items-center justify-between">
        <h1 class="text-4xl font-extrabold text-gray-900 dark:text-gray-100">User Management</h1>
    </div>

    {{-- Back Button Card --}}
    <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 shadow-md">
        <a href="{{ route('admin.index') }}" 
           class="px-4 py-2 rounded-full border-2 border-gray-300 dark:border-gray-700 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 font-bold hover:bg-gray-300 dark:hover:bg-gray-600 transition inline-flex items-center">
            Back to Admin Dashboard
        </a>
    </div>

    {{-- Search & Sort Card --}}
    <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 shadow-md">
        <form method="GET" class="flex flex-col sm:flex-row gap-2 items-start sm:items-center">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Search by name or email..."
                   class="flex-1 px-4 py-2 rounded-full border-2 border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-600">

            <select name="sort" class="px-4 py-2 rounded-full border-2 border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-600">
                <option value="">Sort By</option>
                <option value="warnings_desc" {{ request('sort')=='warnings_desc' ? 'selected' : '' }}>Most Warnings</option>
                <option value="warnings_asc" {{ request('sort')=='warnings_asc' ? 'selected' : '' }}>Least Warnings</option>
                <option value="name_asc" {{ request('sort')=='name_asc' ? 'selected' : '' }}>Name A-Z</option>
                <option value="name_desc" {{ request('sort')=='name_desc' ? 'selected' : '' }}>Name Z-A</option>
            </select>

            <button type="submit" 
                    class="px-4 py-2 rounded-full border-2 border-gray-300 dark:border-gray-700 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 font-bold hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                Apply
            </button>
        </form>
    </div>

    {{-- Users List --}}
    <div class="space-y-6">
        @forelse($users as $user)
            <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition flex flex-col sm:flex-row justify-between items-start sm:items-center">

                {{-- User Info --}}
                <div class="space-y-1">
                    <p class="font-bold text-gray-900 dark:text-gray-100">{{ $user->name }}</p>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">{{ $user->email }}</p>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                        Warnings: 
                        <span class="@if($user->warnings->count() >= 3) text-red-600 font-bold 
                                      @elseif($user->warnings->count() >= 1) text-yellow-600 font-semibold 
                                      @else text-gray-500 @endif">
                            {{ $user->warnings->count() ?? 0 }}
                        </span>
                    </p>
                </div>

                {{-- Actions --}}
                <div class="mt-2 sm:mt-0 flex gap-2 items-center">
                    @if(!$user->isAdmin())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                              onsubmit="return confirm('Delete user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="hover:opacity-70 transition">
                                <img src="{{ asset('icons/delete.svg') }}" alt="Delete" class="w-5 h-5">
                            </button>
                        </form>
                    @else
                        <span class="text-gray-500 dark:text-gray-400 font-semibold">Admin</span>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-500 dark:text-gray-400">No users found.</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $users->appends(request()->query())->links() }}
    </div>

</div>
@endsection
