@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 space-y-6">

    <div class="post-item p-4 rounded-2xl 
                bg-gradient-to-r from-white/30 via-gray-50/50 to-white/30
                backdrop-blur-md border border-gray-200 shadow-sm"
         id="post-{{ $post->id }}">

        <h1 class="text-2xl font-bold text-gray-900">{{ $post->title }}</h1>
        <p class="text-gray-600 mt-1">{{ $post->content }}</p>

        @if($post->media_path)
            <img src="{{ asset('storage/' . $post->media_path) }}" 
                 alt="Post Image" 
                 class="rounded-lg mt-3 max-w-full h-auto">
        @endif

        <p class="text-gray-500 mt-2 text-sm">
            Posted by {{ $post->user->name }} in {{ $post->group->name }}
        </p>

        @php
            $isOwner = auth()->check() && auth()->id() === $post->user_id;
            $liked = auth()->check() && $post->likes->contains(auth()->id());
        @endphp

        {{-- Likes / Comments / Delete / Report --}}
        <div class="flex items-center gap-6 mt-3">

            {{-- Like --}}
            <button type="button" class="like-btn flex items-center gap-1" data-post="{{ $post->id }}">
                <img src="{{ $liked ? asset('icons/liked.svg') : asset('icons/like.svg') }}" 
                     alt="Like" class="w-6 h-6 inline-block">
                <span class="like-count text-gray-700 font-semibold">
                    {{ $post->likes_count ?? $post->likes->count() }}
                </span>
            </button>

            {{-- Comments --}}
            <div class="flex items-center gap-1">
                <img src="{{ asset('icons/comment.svg') }}" alt="Comments" class="w-6 h-6">
                <span class="comment-count text-gray-700 font-semibold">
                    {{ $post->comments_count ?? $post->comments->count() }}
                </span>
            </div>

           @if(auth()->check() && !auth()->user()->isAdmin() && auth()->id() !== $post->user_id)
    <button type="button" id="reportBtn" class="flex items-center gap-1">
        <img src="{{ asset('icons/report.svg') }}" alt="Report" class="w-6 h-6">
    </button>
@endif

            {{-- Success message --}}
            @if(session('success'))
                <p class="text-green-600 font-semibold mt-2">{{ session('success') }}</p>
            @endif

            {{-- Delete --}}
            @if($isOwner || (auth()->check() && auth()->user()->isAdmin()))
                <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this post?');">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="group_id" value="{{ $post->group_id }}">
                    <button type="submit">
                        <img src="{{ asset('icons/delete.svg') }}" alt="Delete" class="w-6 h-6">
                    </button>
                </form>
            @endif
        </div>

        {{-- Comments --}}
        <div class="comments-container mt-3 space-y-2">
            @foreach($post->comments as $comment)
                @include('partials.comment', ['comment' => $comment])
            @endforeach
        </div>

        {{-- Comment Form --}}
        <form class="comment-form mt-3" data-post="{{ $post->id }}">
            @csrf
            <input name="content" required
                   class="w-full p-2 rounded bg-white text-gray-900 border-2 border-gray-300"
                   placeholder="Write a comment...">
        </form>
    </div>
</div>

{{-- Report Modal --}}
<div id="reportModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded-lg max-w-md w-full relative">
        <button id="closeModal" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">&times;</button>
        <h2 class="text-xl font-bold mb-4">Report Post</h2>
        <form action="{{ route('reports.store', $post->id) }}" method="POST">
            @csrf
            <label class="block mb-2 font-semibold text-gray-700">Reason:</label>
            <select name="reason" required class="border rounded p-2 w-full mb-2">
                <option value="" disabled selected>Select a reason</option>
                <option value="Spam">Spam</option>
                <option value="Harassment">Harassment</option>
                <option value="Inappropriate content">Inappropriate content</option>
                <option value="Misinformation">Misinformation</option>
                <option value="Other">Other</option>
            </select>
            <textarea name="details" rows="3" placeholder="Additional details (optional)" class="border rounded p-2 w-full mb-2"></textarea>
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">Submit Report</button>
        </form>
    </div>
</div>

@include('partials.post-scripts', ['groupId' => $post->group_id])

{{-- Modal JS --}}
<script>
document.getElementById('reportBtn').addEventListener('click', function() {
    document.getElementById('reportModal').classList.remove('hidden');
});
document.getElementById('closeModal').addEventListener('click', function() {
    document.getElementById('reportModal').classList.add('hidden');
});
</script>
@endsection
