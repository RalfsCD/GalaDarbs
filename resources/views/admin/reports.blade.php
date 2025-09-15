@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 space-y-6">

    <h1 class="text-2xl font-bold mb-6">All Reports</h1>

    <a href="{{ route('admin.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition mb-4 inline-block">
        Back to Admin Dashboard
    </a>

    @forelse($reports as $report)
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
            <p><strong>Status:</strong> {{ $report->resolved ? 'Resolved' : 'Pending' }}</p>

            @if(!$report->resolved)
                <form action="{{ route('reports.resolve', $report->id) }}" method="POST" class="mt-2">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded">Mark Resolved</button>
                </form>
            @endif
        </div>
    @empty
        <p>No reports available.</p>
    @endforelse
</div>
@endsection
