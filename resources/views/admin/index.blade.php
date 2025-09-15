@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 space-y-6">

    <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>

    {{-- Navigation Buttons --}}
    <div class="flex space-x-4 mb-6">
        <a href="{{ route('admin.reports') }}" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
            All Reports
        </a>
        <a href="{{ route('admin.users') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            Users
        </a>
    </div>

    {{-- Unsolved Reports --}}
    <h2 class="text-xl font-semibold mb-2">Unsolved Reports</h2>

    @forelse($unsolvedReports as $report)
        <div class="p-4 rounded-lg border bg-white shadow-sm mb-4">
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
            <form action="{{ route('admin.reports.resolve', $report->id) }}" method="POST" class="mt-2">
                @csrf
                @method('PATCH')
                <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded">Mark Resolved</button>
            </form>
        </div>
    @empty
        <p>No unsolved reports!</p>
    @endforelse
</div>
@endsection
