@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 space-y-4">
    <h1 class="text-2xl font-bold mb-4">Notifications</h1>

   @forelse($notifications as $notification)
    <div class="p-4 rounded-2xl bg-white/30 backdrop-blur-md border border-gray-200 shadow-sm hover:shadow-md transition">
        @php $data = $notification->data; @endphp

        <p class="text-gray-900">
            @if($data['type'] === 'post_deleted')
                Your post "{{ $data['post_title'] ?? '' }}" has been reported and deleted by admin.
            @elseif($data['type'] === 'post_liked')
                {{ $data['user_name'] ?? 'Someone' }} liked your post "{{ $data['post_title'] ?? '' }}".
            @elseif($data['type'] === 'post_commented')
                {{ $data['user_name'] ?? 'Someone' }} commented on your post "{{ $data['post_title'] ?? '' }}".
            @endif
        </p>
    </div>
@empty
    <p class="text-gray-500">No notifications yet.</p>
@endforelse

</div>
@endsection
