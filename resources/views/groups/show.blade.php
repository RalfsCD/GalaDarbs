@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 space-y-6">

    <!-- Group Info -->
    <div class="bg-gray-800 p-4 rounded-lg">
        <h1 class="text-3xl text-yellow-400 font-bold">{{ $group->name }}</h1>
        <p class="text-gray-300">{{ $group->description }}</p>
    </div>

    <!-- Create Post -->
    <div class="bg-gray-700 p-4 rounded-lg">
        <form id="create-post-form" enctype="multipart/form-data">
            @csrf
            <input type="text" name="title" placeholder="Post title..." class="w-full p-2 mb-2 rounded bg-black text-yellow-400 border-2 border-yellow-400">
            <textarea name="content" rows="3" placeholder="Content..." class="w-full p-2 mb-2 rounded bg-black text-yellow-400 border-2 border-yellow-400"></textarea>
            <input type="file" name="media" class="mb-2">
            <button class="bg-yellow-400 text-black px-4 py-2 rounded font-bold">Post</button>
        </form>
    </div>

    <!-- Sort Posts -->
    <div class="flex justify-end mb-2">
        <select id="sort-posts" class="bg-gray-800 text-yellow-400 p-2 rounded">
            <option value="newest">Newest First</option>
            <option value="oldest">Oldest First</option>
            <option value="most_liked">Most Liked</option>
        </select>
    </div>

    <!-- Posts Feed -->
    <div id="posts-container">
        @foreach($group->posts()->with('user','comments.user','likes')->latest()->get() as $post)
            @include('partials.post', ['post' => $post])
        @endforeach
    </div>
</div>

<script>
    const groupId = {{ $group->id }};

    // Create Post AJAX
    document.getElementById('create-post-form').addEventListener('submit', function(e){
        e.preventDefault();
        let formData = new FormData(this);

        fetch(`/groups/${groupId}/posts`, {
            method:'POST',
            headers:{ 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('posts-container').insertAdjacentHTML('afterbegin', data.html);
            this.reset();
        });
    });

    // Sort Posts AJAX
    document.getElementById('sort-posts').addEventListener('change', function(){
        let sort = this.value;

        fetch(`/groups/${groupId}?sort=${sort}`, {
            headers:{ 'X-Requested-With':'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('posts-container').innerHTML = data.html;
        });
    });

    // Delegate Like, Comment, Delete actions
    document.getElementById('posts-container').addEventListener('click', function(e){
        // Like
        if(e.target.classList.contains('like-btn')){
            e.preventDefault();
            let postId = e.target.dataset.post;
            fetch(`/posts/${postId}/like`, {
                method:'POST',
                headers:{ 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(res => res.json())
            .then(data => { e.target.innerText = `👍 ${data.likes}`; });
        }

        // Delete
        if(e.target.classList.contains('delete-btn')){
            e.preventDefault();
            let postId = e.target.dataset.post;
            fetch(`/posts/${postId}`, {
                method:'DELETE',
                headers:{ 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) e.target.closest('.post-item').remove();
            });
        }
    });

    // Comment submit
    // Comment submit
document.getElementById('posts-container').addEventListener('submit', function(e){
    if(e.target.classList.contains('comment-form')){
        e.preventDefault();
        let postId = e.target.dataset.post;
        let formData = new FormData(e.target);

        fetch(`/posts/${postId}/comment`, {
            method:'POST',
            headers:{ 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            let commentsDiv = e.target.closest('.post-item').querySelector('.comments-container');
            // Append new comment HTML
            commentsDiv.insertAdjacentHTML('beforeend', data.html);

            // Update comment count dynamically
            let commentCountSpan = e.target.closest('.post-item').querySelector('.comment-count');
            commentCountSpan.innerText = `${data.comment_count} ${data.comment_count === 1 ? 'comment' : 'comments'}`;

            // Reset input
            e.target.reset();
        });
    }
});

    
</script>
@endsection
