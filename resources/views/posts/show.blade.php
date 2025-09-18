@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-8 space-y-8">

    <div class="post-item p-6 rounded-2xl 
                bg-gradient-to-r from-white/40 via-gray-50/70 to-white/40
                backdrop-blur-md border border-gray-300 shadow-md"
         id="post-{{ $post->id }}">

        {{-- Post Header with avatar --}}
        <div class="flex items-center gap-3 mb-5">
            @if($post->user->profile_photo_path)
                <img src="{{ asset('storage/' . $post->user->profile_photo_path) }}" 
                     alt="{{ $post->user->name }}" 
                     class="w-12 h-12 rounded-full object-cover shadow">
            @else
                <div class="w-12 h-12 rounded-full bg-gray-400 flex items-center justify-center text-white font-bold text-lg shadow">
                    {{ strtoupper(substr($post->user->name, 0, 2)) }}
                </div>
            @endif
            <div>
                <p class="text-gray-900 font-bold text-lg">{{ $post->user->name }}</p>
                <p class="text-sm text-gray-700">
                    in 
                    <span class="bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded-full font-medium">
                        {{ $post->group->name }}
                    </span>
                </p>
            </div>
        </div>

        {{-- Post Content --}}
        @if($post->media_path)
            <img src="{{ asset('storage/' . $post->media_path) }}" 
                 alt="Post Image" 
                 class="rounded-xl mt-4 max-w-full w-full object-cover shadow-lg">
        @endif

        @if($post->content)
            <p class="mt-6 text-lg leading-relaxed text-gray-800">
                {{ $post->content }}
            </p>
        @endif

        @php
            $isOwner = auth()->check() && auth()->id() === $post->user_id;
            $liked = auth()->check() && $post->likes->contains(auth()->id());
        @endphp

        {{-- Likes / Comments / Delete / Report --}}
        <div class="flex items-center gap-8 mt-6 text-lg">

            {{-- Like --}}
            <button type="button" class="like-btn flex items-center gap-2" data-post="{{ $post->id }}">
                <img src="{{ $liked ? asset('icons/liked.svg') : asset('icons/like.svg') }}" 
                     alt="Like" class="w-7 h-7 inline-block">
                <span class="like-count text-gray-700 font-semibold">
                    {{ $post->likes_count ?? $post->likes->count() }}
                </span>
            </button>

            {{-- Comments --}}
            <div class="flex items-center gap-2">
                <img src="{{ asset('icons/comment.svg') }}" alt="Comments" class="w-7 h-7">
                <span class="comment-count text-gray-700 font-semibold">
                    {{ $post->comments_count ?? $post->comments->count() }}
                </span>
            </div>

            {{-- Report --}}
            @if(auth()->check() && !auth()->user()->isAdmin() && auth()->id() !== $post->user_id)
                <button type="button" id="reportBtn" class="flex items-center gap-2">
                    <img src="{{ asset('icons/report.svg') }}" alt="Report" class="w-7 h-7">
                    <span class="text-sm text-gray-600"></span>
                </button>
            @endif

            {{-- Success message --}}
            @if(session('success'))
                <p class="text-green-600 font-semibold mt-2">{{ session('success') }}</p>
            @endif

            {{-- Delete --}}
            @if($isOwner || (auth()->check() && auth()->user()->isAdmin()))
                <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this post?');" class="ml-auto">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="group_id" value="{{ $post->group_id }}">
                    <button type="submit" class="flex items-center gap-2 text-red-600 hover:text-red-800">
                        <img src="{{ asset('icons/delete.svg') }}" alt="Delete" class="w-7 h-7">
                        <span class="text-sm"></span>
                    </button>
                </form>
            @endif
        </div>

        {{-- Comments --}}
        <div class="comments-container mt-6 space-y-3">
            @foreach($post->comments as $comment)
                @include('partials.comment', ['comment' => $comment])
            @endforeach
        </div>

        {{-- Comment Form --}}
        <form class="comment-form mt-6" data-post="{{ $post->id }}">
            @csrf
            <input name="content" required
                   class="w-full p-3 rounded-lg bg-white text-gray-900 border-2 border-gray-300 shadow-sm"
                   placeholder="Write a comment...">
        </form>
    </div>
</div>

{{-- Report Modal --}}
<div id="reportModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-8 rounded-xl max-w-lg w-full relative shadow-lg">
        <button id="closeModal" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-2xl">&times;</button>
        <h2 class="text-2xl font-bold mb-5">Report Post</h2>
        <form action="{{ route('reports.store', $post->id) }}" method="POST">
            @csrf
            <label class="block mb-2 font-semibold text-gray-700">Reason:</label>
            <select name="reason" required class="border rounded p-3 w-full mb-3">
                <option value="" disabled selected>Select a reason</option>
                <option value="Spam">Spam</option>
                <option value="Harassment">Harassment</option>
                <option value="Inappropriate content">Inappropriate content</option>
                <option value="Misinformation">Misinformation</option>
                <option value="Other">Other</option>
            </select>
            <textarea name="details" rows="3" placeholder="Additional details (optional)" class="border rounded p-3 w-full mb-3"></textarea>
            <button type="submit" class="px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">Submit Report</button>
        </form>
    </div>
</div>

@include('partials.post-scripts', ['groupId' => $post->group_id])

{{-- Modal JS --}}
<script>
document.getElementById('reportBtn')?.addEventListener('click', function() {
    document.getElementById('reportModal').classList.remove('hidden');
});
document.getElementById('closeModal')?.addEventListener('click', function() {
    document.getElementById('reportModal').classList.add('hidden');
});
</script>
@endsection
