<script>
document.addEventListener("DOMContentLoaded", () => {
    const token = document.querySelector('meta[name="csrf-token"]')?.content;

    // -------------------------------
    // LIKE TOGGLE (CLICK)
    // -------------------------------
    document.addEventListener("click", async e => {
        const btn = e.target.closest(".like-btn");
        if (!btn) return;
        await toggleLikeRequest(btn.dataset.post, btn);
    });

    // -------------------------------
    // DOUBLE CLICK (DESKTOP)
    // -------------------------------
    document.addEventListener("dblclick", async e => {
        const card = e.target.closest(".post-card");
        if (!card) return;
        e.preventDefault(); // prevent text selection
        const postId = card.dataset.postId;
        if (!postId) return;
        await toggleLikeRequest(postId, card.querySelector(".like-btn"));
        showFloatingHeart(card);
    });

    // -------------------------------
    // DOUBLE TAP (MOBILE)
    // -------------------------------
    const lastTapByPost = new Map();
    document.addEventListener("touchend", async e => {
        const card = e.target.closest(".post-card");
        if (!card) return;
        const postId = card.dataset.postId;
        const now = Date.now();
        const last = lastTapByPost.get(postId) || 0;
        lastTapByPost.set(postId, now);
        if (now - last < 300) {
            e.preventDefault();
            await toggleLikeRequest(postId, card.querySelector(".like-btn"));
            showFloatingHeart(card);
        }
    }, { passive: false });

    // -------------------------------
    // LIKE REQUEST
    // -------------------------------
    async function toggleLikeRequest(postId, btn) {
        if (!postId) return;
        try {
            const res = await fetch(`/posts/${postId}/like`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": token,
                    "Accept": "application/json"
                }
            });
            if (!res.ok) return;
            const data = await res.json();
            updateLikeUI(btn, data.liked, data.likes);
        } catch(err) { console.error("Like failed", err); }
    }

    // Update like button UI
    function updateLikeUI(btn, liked, likes) {
        if (!btn) return;
        btn.querySelector(".like-count").textContent = likes;
        const icon = btn.querySelector(".like-icon");
        if (liked) {
            icon.classList.add("fill-current","text-red-600","dark:text-red-500");
            icon.setAttribute("fill","currentColor");
        } else {
            icon.classList.remove("fill-current","text-red-600","dark:text-red-500");
            icon.classList.add("text-gray-500","dark:text-gray-400");
            icon.setAttribute("fill","none");
        }
    }

    // Floating heart animation
    function showFloatingHeart(card) {
        if (!card) return;
        const heart = document.createElement("div");
        heart.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
             fill="currentColor" class="w-20 h-20 text-red-500">
            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 
                     2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 
                     3.41.81 4.5 2.09C13.09 3.81 14.76 
                     3 16.5 3 19.58 3 22 5.42 22 
                     8.5c0 3.78-3.4 6.86-8.55 
                     11.54L12 21.35z"/>
        </svg>`;
        heart.className = "absolute inset-0 flex items-center justify-center pointer-events-none animate-pop-heart";
        card.style.position = "relative";
        card.appendChild(heart);
        setTimeout(() => heart.remove(), 900);
    }

    // -------------------------------
    // COMMENT DRAWER
    // -------------------------------
    const drawer = document.getElementById("commentDrawer");
    const commentsList = document.getElementById("commentsList");
    const commentForm = document.getElementById("commentForm");
    const closeComments = document.getElementById("closeComments");
    const postIdInput = document.getElementById("commentPostId");

    // Open drawer
    document.addEventListener("click", async e => {
        const btn = e.target.closest(".comment-trigger");
        if (!btn) return;

        const postId = btn.dataset.post;
        postIdInput.value = postId;

        drawer.classList.remove("hidden");
        drawer.classList.add("flex");

        commentsList.innerHTML = `<p class="text-gray-500 text-sm">Loading comments...</p>`;

        try {
            const res = await fetch(`/posts/${postId}/comments`, {
                headers: { "Accept": "application/json" }
            });
            if (!res.ok) throw new Error("Failed to fetch comments");

            const data = await res.json();
            commentsList.innerHTML = "";

            if (data.comments.length === 0) {
                commentsList.innerHTML = `<p class="text-gray-500 italic text-sm">No comments yet.</p>`;
            } else {
                data.comments.forEach(c => commentsList.insertAdjacentHTML("beforeend", renderComment(c)));
            }
        } catch (err) {
            console.error("Comments fetch failed", err);
            commentsList.innerHTML = `<p class="text-red-500 text-sm">Failed to load comments</p>`;
        }
    });

    // Close drawer
    closeComments?.addEventListener("click", () => {
        drawer.classList.add("hidden");
        drawer.classList.remove("flex");
    });

    // Submit comment
    commentForm?.addEventListener("submit", async e => {
        e.preventDefault();
        const postId = postIdInput.value;
        const content = commentForm.content.value.trim();
        if (!content) return;

        try {
            const res = await fetch(`/posts/${postId}/comment`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": token,
                    "Accept": "application/json",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ content })
            });
            if (!res.ok) throw new Error("Failed to send comment");
            const data = await res.json();

            // Append comment
            commentsList.insertAdjacentHTML("beforeend", renderComment(data.comment));

            // Update counter
            document.querySelectorAll(`[data-post='${postId}'] .comment-count`).forEach(el => {
                el.textContent = data.comments;
            });

            commentForm.reset();
        } catch (err) {
            console.error("Comment failed", err);
        }
    });

    function renderComment(c) {
        const avatar = c.user.profile_photo_path
            ? `<img src="/storage/${c.user.profile_photo_path}" class="w-8 h-8 rounded-full object-cover">`
            : `<div class="w-8 h-8 rounded-full bg-yellow-500 flex items-center justify-center text-white text-xs font-bold">${c.user.name.charAt(0)}</div>`;

        return `
        <div class="flex items-start gap-3 p-3 rounded-lg bg-gray-100 dark:bg-gray-800">
            ${avatar}
            <div>
                <p class="font-semibold text-sm text-gray-900 dark:text-gray-100">
                    ${c.user.name} <span class="ml-1 text-xs text-gray-500">${c.created_at}</span>
                </p>
                <p class="text-gray-700 dark:text-gray-300 text-sm">${c.content}</p>
            </div>
        </div>`;
    }

    // -------------------------------
    // IMAGE LIGHTBOX
    // -------------------------------
    const imageModal = document.getElementById("imageModal");
    const modalImage = document.getElementById("modalImage");
    const closeImageModal = document.getElementById("closeImageModal");

    // Open when clicking expand button
    document.addEventListener("click", e => {
        const btn = e.target.closest(".expand-image");
        if (!btn) return;
        const img = btn.closest("div").querySelector(".post-image");
        if (!img) return;
        modalImage.src = img.dataset.src || img.src;
        imageModal.classList.remove("hidden");
        imageModal.classList.add("flex");
    });

    closeImageModal?.addEventListener("click", () => {
        imageModal.classList.add("hidden");
        imageModal.classList.remove("flex");
    });

    imageModal?.addEventListener("click", e => {
        if (e.target === imageModal) {
            imageModal.classList.add("hidden");
            imageModal.classList.remove("flex");
        }
    });
});
</script>

<style>
@keyframes pop-heart {
  0% { transform: scale(0.3); opacity: 0; }
  40% { transform: scale(1.35); opacity: 1; }
  100% { transform: scale(1); opacity: 0; }
}
.animate-pop-heart { animation: pop-heart 0.9s ease forwards; }

/* Disable text selection on post cards */
.post-card { user-select: none; }
</style>
