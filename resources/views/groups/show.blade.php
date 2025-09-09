@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 space-y-6">

    {{-- Group Info --}}
    <div class="bg-gray-800 p-4 rounded-lg">
        <h1 class="text-3xl text-yellow-400 font-bold">{{ $group->name }}</h1>
        <p class="text-gray-300">{{ $group->description }}</p>
    </div>

    {{-- Create Post --}}
    <div class="bg-gray-700 p-4 rounded-lg">
        <form id="create-post-form" enctype="multipart/form-data">
            @csrf
            <input type="text" name="title" placeholder="Post title..." class="w-full p-2 mb-2 rounded bg-black text-yellow-400 border-2 border-yellow-400" required>
            <textarea name="content" rows="3" placeholder="Content..." class="w-full p-2 mb-2 rounded bg-black text-yellow-400 border-2 border-yellow-400"></textarea>
            <input type="file" name="media" class="mb-2">
            <button class="bg-yellow-400 text-black px-4 py-2 rounded font-bold">Post</button>
        </form>
    </div>

    {{-- Sort Posts --}}
    <div class="flex justify-end mb-2">
        <select id="sort-posts" class="bg-gray-800 text-yellow-400 p-2 rounded">
            <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest First</option>
            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
            <option value="most_liked" {{ request('sort') === 'most_liked' ? 'selected' : '' }}>Most Liked</option>
        </select>
    </div>

    {{-- Posts Feed --}}
    <div id="posts-container">
        @include('partials.posts', ['posts' => $posts])
    </div>
</div>

<script>
(function () {
    const groupId = {{ $group->id }};
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
    const postsContainer = document.getElementById('posts-container');

    const okOrThrow = async (res) => {
        if (res.redirected) {
            // most likely auth/verify middleware – navigate to see why
            window.location = res.url;
            throw new Error('Redirected to ' + res.url);
        }
        if (!res.ok) {
            const text = await res.text().catch(()=> '');
            throw new Error(`HTTP ${res.status}: ${text.slice(0,200)}`);
        }
        return res;
    };

    const isJson = (res) => (res.headers.get('content-type') || '').includes('application/json');

    // Create Post (AJAX)
    document.getElementById('create-post-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const fd = new FormData(this);
        fetch(`/groups/${groupId}/posts`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: fd
        })
        .then(okOrThrow)
        .then(async (r) => isJson(r) ? r.json() : Promise.reject(new Error('Non-JSON response (are you logged in/verified?)')))
        .then(data => {
            postsContainer.insertAdjacentHTML('afterbegin', data.html);
            this.reset();
        })
        .catch(err => {
            console.error('Create post failed:', err);
            alert('Failed to create post. Are you logged in and email verified? Check console.');
        });
    });

    // Sort Posts (AJAX)
    document.getElementById('sort-posts').addEventListener('change', function () {
        const sort = this.value;
        fetch(`/groups/${groupId}?sort=${encodeURIComponent(sort)}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(okOrThrow)
        .then(async (r) => isJson(r) ? r.json() : Promise.reject(new Error('Non-JSON response')))
        .then(data => { postsContainer.innerHTML = data.html; })
        .catch(err => { console.error('Sort failed:', err); alert('Failed to sort. Check console.'); });
    });

    // Delegate Like & Delete
    postsContainer.addEventListener('click', function (e) {
        // LIKE
        const likeBtn = e.target.closest('.like-btn');
        if (likeBtn) {
            e.preventDefault();
            const postId = likeBtn.dataset.post;
            fetch(`/posts/${postId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(okOrThrow)
            .then(async (r) => isJson(r) ? r.json() : Promise.reject(new Error('Non-JSON response')))
            .then(data => {
                const postItem = likeBtn.closest('.post-item');
                const countSpan = postItem?.querySelector('.like-count');
                if (countSpan) countSpan.textContent = data.likes;
                if ('liked' in data) likeBtn.classList.toggle('liked', !!data.liked);
            })
            .catch(err => { console.error('Like failed:', err); alert('Failed to like. Check console.'); });
            return;
        }

        // DELETE
        const delBtn = e.target.closest('.delete-btn');
        if (delBtn) {
            e.preventDefault();
            const postId = delBtn.dataset.post;
            fetch(`/posts/${postId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(okOrThrow)
            .then(async (r) => isJson(r) ? r.json() : Promise.reject(new Error('Non-JSON response')))
            .then(data => { if (data.success) delBtn.closest('.post-item')?.remove(); })
            .catch(err => { console.error('Delete failed:', err); alert('Failed to delete. Check console.'); });
        }
    });

    // Comment submit
    postsContainer.addEventListener('submit', function (e) {
        const form = e.target;
        if (form.classList.contains('comment-form')) {
            e.preventDefault();
            const postId = form.dataset.post;
            const fd = new FormData(form);

            fetch(`/posts/${postId}/comment`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: fd
            })
            .then(okOrThrow)
            .then(async (r) => isJson(r) ? r.json() : Promise.reject(new Error('Non-JSON response')))
            .then(data => {
                const postItem = form.closest('.post-item');
                postItem.querySelector('.comments-container').insertAdjacentHTML('beforeend', data.html);
                const cc = postItem.querySelector('.comment-count');
                if (cc) cc.textContent = `${data.comment_count} ${data.comment_count === 1 ? 'comment' : 'comments'}`;
                form.reset();
            })
            .catch(err => { console.error('Comment failed:', err); alert('Failed to comment. Check console.'); });
        }
    });
})();
</script>
@endsection
