    <script>
    (function () {
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
        const postsContainer = document.getElementById('posts-container') || document;

        const okOrThrow = async (res) => {
            if (res.redirected) { window.location = res.url; throw new Error('Redirected'); }
            if (!res.ok) { const t = await res.text().catch(()=> ''); throw new Error(`HTTP ${res.status}: ${t}`); }
            return res;
        };
        const isJson = (res) => (res.headers.get('content-type') || '').includes('application/json');

        // Like & Delete
        postsContainer.addEventListener('click', function (e) {
            const likeBtn = e.target.closest('.like-btn');
            if (likeBtn) {
                e.preventDefault();
                const postId = likeBtn.dataset.post;
                fetch(`/posts/${postId}/like`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': token, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                })
                .then(okOrThrow).then(r => isJson(r) ? r.json() : Promise.reject())
                .then(data => {
                    const postItem = likeBtn.closest('.post-item');
                    const countSpan = postItem?.querySelector('.like-count');
                    if (countSpan) countSpan.textContent = data.likes;
                    if ('liked' in data) likeBtn.classList.toggle('liked', !!data.liked);
                }).catch(err => console.error(err));
                return;
            }

            // Delete
            const delBtn = e.target.closest('.delete-btn');
            if (delBtn) {
                e.preventDefault();
                const postId = delBtn.dataset.post;
                if (!confirm('Are you sure you want to delete this post?')) return;
                fetch(`/posts/${postId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': token, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                })
                .then(okOrThrow).then(r => isJson(r) ? r.json() : Promise.reject())
                .then(data => { if (data.success) delBtn.closest('.post-item')?.remove(); })
                .catch(err => console.error(err));
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
                    headers: { 'X-CSRF-TOKEN': token, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                    body: fd
                })
                .then(okOrThrow).then(r => isJson(r) ? r.json() : Promise.reject())
                .then(data => {
                    const postItem = form.closest('.post-item');
                    postItem.querySelector('.comments-container').insertAdjacentHTML('beforeend', data.html);
                    const cc = postItem.querySelector('.comment-count');
                    if (cc) cc.textContent = `${data.comment_count} ${data.comment_count === 1 ? 'comment' : 'comments'}`;
                    form.reset();
                }).catch(err => console.error(err));
            }
        });

    })();
    </script>
