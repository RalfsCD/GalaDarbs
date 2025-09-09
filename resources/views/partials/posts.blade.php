@forelse($posts as $post)
    @include('partials.post', ['post' => $post])
@empty
    <p class="text-gray-400">No posts yet.</p>
@endforelse
