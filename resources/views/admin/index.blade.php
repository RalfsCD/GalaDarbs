@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 space-y-6">

    {{-- Page Header Card --}}
    <div class="p-6 rounded-2xl 
                bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                backdrop-blur-md border border-gray-200 shadow-sm mb-6 flex justify-between items-center">
       <h1 class="text-4xl font-extrabold text-gray-900">Admin dashboard</h1>
    </div>

    {{-- Navigation Buttons Card --}}
    <div class="p-4 rounded-2xl 
                bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                backdrop-blur-md border border-gray-200 shadow-sm mb-6 flex flex-wrap gap-2">
        <a href="{{ route('admin.reports') }}" 
           class="px-4 py-2 rounded-full border-2 border-gray-300 bg-gray-200 text-gray-900 font-bold hover:bg-gray-300 transition inline-flex items-center">
            All Reports
        </a>
        <a href="{{ route('admin.users') }}" 
           class="px-4 py-2 rounded-full border-2 border-gray-300 bg-gray-200 text-gray-900 font-bold hover:bg-gray-300 transition inline-flex items-center">
            Users
        </a>
    </div>

    {{-- Unsolved Reports --}}
    <h2 class="text-xl font-semibold mb-2">Unsolved Reports</h2>

    <div class="space-y-4">
        @forelse($unsolvedReports as $report)
            <div class="p-6 rounded-2xl 
                        bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                        backdrop-blur-md border border-gray-200 shadow-sm hover:shadow-md transition space-y-3">

                <p><strong>Post:</strong>
                    @if($report->post && $report->post->id)
                        <a href="{{ route('posts.show', $report->post->id) }}" class="text-blue-600 hover:underline">
                            {{ Str::limit($report->post->title, 50) }}
                        </a>
                    @else
                        <span class="text-gray-500">[Deleted]</span>
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
                            class="px-4 py-2 rounded-full border-2 border-gray-300 bg-gray-200 text-gray-900 font-bold hover:bg-gray-300 transition">
                        Mark Resolved
                    </button>
                </form>
            </div>
        @empty
            <p class="text-gray-500">No unsolved reports!</p>
        @endforelse
    </div>
</div>
@endsection
