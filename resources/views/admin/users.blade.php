@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 space-y-6">

    {{-- Page Header Card --}}
    <div class="p-6 rounded-2xl 
                bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                backdrop-blur-md border border-gray-200 shadow-sm flex justify-between items-center mb-6">
               <h1 class="text-4xl font-extrabold text-gray-900">User management</h1>
    </div>

    {{-- Back Button Card --}}
    <div class="p-4 rounded-2xl 
                bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                backdrop-blur-md border border-gray-200 shadow-sm mb-6 flex">
        <a href="{{ route('admin.index') }}" 
           class="px-4 py-2 rounded-full border-2 border-gray-300 bg-gray-200 text-gray-900 font-bold hover:bg-gray-300 transition inline-flex items-center">
            Back to Admin Dashboard
        </a>
    </div>

    {{-- Search & Sort Card --}}
    <div class="p-4 rounded-2xl 
                bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                backdrop-blur-md border border-gray-200 shadow-sm mb-6">
        <form method="GET" class="flex flex-col sm:flex-row gap-2 items-start sm:items-center">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Search by name or email..."
                   class="flex-1 px-4 py-2 rounded-full border-2 border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">

            <select name="sort" class="px-4 py-2 rounded-full border-2 border-gray-300 bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-300">
                <option value="">Sort By</option>
                <option value="warnings_desc" {{ request('sort')=='warnings_desc' ? 'selected' : '' }}>Most Warnings</option>
                <option value="warnings_asc" {{ request('sort')=='warnings_asc' ? 'selected' : '' }}>Least Warnings</option>
                <option value="name_asc" {{ request('sort')=='name_asc' ? 'selected' : '' }}>Name A-Z</option>
                <option value="name_desc" {{ request('sort')=='name_desc' ? 'selected' : '' }}>Name Z-A</option>
            </select>

            <button type="submit" 
                    class="px-4 py-2 rounded-full border-2 border-gray-300 bg-gray-200 text-gray-900 font-bold hover:bg-gray-300 transition">
                Apply
            </button>
        </form>
    </div>

    {{-- Users List --}}
    <div class="space-y-4">
        @forelse($users as $user)
            <div class="p-4 rounded-2xl 
                        bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                        backdrop-blur-md border border-gray-200 shadow-sm hover:shadow-md transition flex flex-col sm:flex-row justify-between items-start sm:items-center">

                {{-- User Info --}}
                <div class="space-y-1">
                    <p class="font-bold text-gray-900">{{ $user->name }}</p>
                    <p class="text-gray-600 text-sm">{{ $user->email }}</p>
                    <p class="text-gray-500 text-sm">
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
                        <span class="text-gray-500 font-semibold">Admin</span>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-500">No users found.</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $users->appends(request()->query())->links() }}
    </div>
</div>
@endsection
