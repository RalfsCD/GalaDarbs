@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 space-y-6">

    {{-- Page Header Card --}}
    <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 shadow-md flex items-center justify-between">
        <h1 class="text-4xl font-extrabold text-gray-900 dark:text-gray-100">All Reports</h1>
    </div>

    {{-- Back Button Card --}}
    <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 shadow-md">
        <a href="{{ route('admin.index') }}" 
           class="px-4 py-2 rounded-full border-2 border-gray-300 dark:border-gray-700 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 font-bold hover:bg-gray-300 dark:hover:bg-gray-600 transition inline-flex items-center">
            Back to Admin Dashboard
        </a>
    </div>

    {{-- Reports List --}}
    <div class="space-y-6">
        @forelse($reports as $report)
            <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg transition space-y-4">
                <p><strong>Post:</strong>
                    @if($report->post && $report->post->id)
                        <a href="{{ route('posts.show', $report->post->id) }}" class="text-blue-600 hover:underline">
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
                <p><strong>Status:</strong> 
                    <span class="@if($report->resolved) text-green-600 font-semibold @else text-yellow-600 font-semibold @endif">
                        {{ $report->resolved ? 'Resolved' : 'Pending' }}
                    </span>
                </p>

                @if(!$report->resolved)
                    <form action="{{ route('admin.reports.resolve', $report->id) }}" method="POST" class="mt-3">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="px-4 py-2 rounded-full border-2 border-gray-300 dark:border-gray-600 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 font-bold hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                            Mark Resolved
                        </button>
                    </form>
                @endif
            </div>
        @empty
            <p class="text-gray-500 dark:text-gray-400">No reports available.</p>
        @endforelse
    </div>
</div>
@endsection
