@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 space-y-6">

    {{-- Page Header --}}
    <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 shadow-md flex items-center justify-between">
        <h1 class="text-4xl font-extrabold text-gray-900 dark:text-gray-100">Admin Dashboard</h1>
    </div>

    {{-- Navigation Buttons --}}
    <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 shadow-md">
        <div class="flex gap-4">
            <a href="{{ route('admin.reports') }}" 
               class="px-5 py-2.5 rounded-full bg-yellow-500 text-white font-bold border border-yellow-400 shadow-md hover:bg-yellow-600 hover:shadow-lg transition flex items-center gap-2">
                All Reports
            </a>
            <a href="{{ route('admin.users') }}" 
               class="px-5 py-2.5 rounded-full bg-yellow-500 text-white font-bold border border-yellow-400 shadow-md hover:bg-yellow-600 hover:shadow-lg transition flex items-center gap-2">
                Users
            </a>
        </div>
    </div>

    {{-- Unsolved Reports --}}
    <h2 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100">Unsolved Reports</h2>

    <div class="space-y-6">
        @forelse($unsolvedReports as $report)
        <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg transition space-y-3">
            <p><strong>Post:</strong>
                @if($report->post && $report->post->id)
                    <a href="{{ route('posts.show', $report->post->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                        {{ Str::limit($report->post->title, 50) }}
                    </a>
                @else
                    <span class="text-gray-500 dark:text-gray-400">[Deleted]</span>
                @endif
            </p>

            <p><strong>Reported User:</strong> {{ $report->reportedUser->name }}</p>
            <p><strong>Reporter:</strong> {{ $report->reporter->name }}</p>
            <p><strong>Reason:</strong> {{ $report->reason }}</p>
            <p><strong>Details:</strong> {{ $report->details ?? 'N/A' }}</p>

            {{-- Resolve Button --}}
            <form action="{{ route('admin.reports.resolve', $report->id) }}" method="POST" class="mt-3">
                @csrf
                @method('PATCH')
                <button type="submit" 
                        class="px-4 py-2 rounded-full border-2 border-gray-300 dark:border-gray-600 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 font-bold hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                    Mark Resolved
                </button>
            </form>
        </div>
        @empty
            <p class="text-gray-500 dark:text-gray-400">No unsolved reports!</p>
        @endforelse
    </div>
</div>
@endsection
