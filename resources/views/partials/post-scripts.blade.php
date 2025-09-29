<script>
document.addEventListener("DOMContentLoaded", () => {
    const token = document.querySelector('meta[name="csrf-token"]')?.content;

   
    const inFlight = new Set(); 
    const suppressUntil = new Map(); 
    const SUPPRESS_MS = 450;

    const isCoarsePointer = window.matchMedia && window.matchMedia("(pointer: coarse)").matches;
    const isTouchCapable =
        ("ontouchstart" in window) || (navigator.maxTouchPoints > 0) || isCoarsePointer;

    function shouldSuppress(postId) {
        return (suppressUntil.get(postId) || 0) > Date.now();
    }
    function suppress(postId) {
        suppressUntil.set(postId, Date.now() + SUPPRESS_MS);
    }

    
    document.addEventListener("click", async e => {
        
        if (e.target.closest(".expand-image")) return;

        const btn = e.target.closest(".like-btn");
        if (!btn) return;

        const postId = btn.dataset.post;
        if (!postId) return;
        if (inFlight.has(postId) || shouldSuppress(postId)) return;

        suppress(postId);
        await toggleLikeRequest(postId, btn);
    });

   
    if (!isTouchCapable) {
        document.addEventListener("dblclick", async e => {
            
            if (e.target.closest(".like-btn") || e.target.closest(".expand-image")) return;

            const card = e.target.closest(".post-card");
            if (!card) return;

            e.preventDefault();
            e.stopPropagation();

            const postId = card.dataset.postId;
            if (!postId) return;
            if (inFlight.has(postId) || shouldSuppress(postId)) return;

            suppress(postId);
            await toggleLikeRequest(postId, card.querySelector(".like-btn"));
            showFloatingHeart(card);
        });
    }

   
    if (isTouchCapable) {
        const lastTapByPost = new Map();

        
        document.addEventListener("touchstart", e => {
            const card = e.target.closest(".post-card");
            if (!card) return;
            if (e.target.closest(".expand-image")) return; 

            const postId = card.dataset.postId;
            const now = Date.now();
            const last = lastTapByPost.get(postId) || 0;

            if (now - last < 300) {
                
                e.preventDefault();
                e.stopPropagation();
            }
        }, { passive: false });

        document.addEventListener("touchend", async e => {
            const card = e.target.closest(".post-card");
            if (!card) return;
            if (e.target.closest(".expand-image")) return;

            const postId = card.dataset.postId;
            if (!postId) return;

            const now = Date.now();
            const last = lastTapByPost.get(postId) || 0;
            lastTapByPost.set(postId, now);

            
            if (now - last < 300) {
                
                e.preventDefault();
                e.stopPropagation();

                if (inFlight.has(postId) || shouldSuppress(postId)) return;

                suppress(postId);
                await toggleLikeRequest(postId, card.querySelector(".like-btn"));
                showFloatingHeart(card);
            }
        }, { passive: false });
    }

    async function toggleLikeRequest(postId, btn) {
        if (!postId || !btn) return;
        if (inFlight.has(postId)) return; 

        inFlight.add(postId);
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
        } catch(err) {
            console.error("Like failed", err);
        } finally {
            inFlight.delete(postId);
        }
    }

    
    function updateLikeUI(btn, liked, likes) {
        if (!btn) return;
        btn.querySelector(".like-count").textContent = likes;
        const icon = btn.querySelector(".like-icon");
        if (liked) {
            icon.classList.add("fill-current","text-red-600","dark:text-red-500");
            icon.classList.remove("text-gray-500","dark:text-gray-400");
            icon.setAttribute("fill","currentColor");
        } else {
            icon.classList.remove("fill-current","text-red-600","dark:text-red-500");
            icon.classList.add("text-gray-500","dark:text-gray-400");
            icon.setAttribute("fill","none");
        }
    }

   
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
        const prevPos = card.style.position;
        if (!prevPos || prevPos === "static") card.style.position = "relative";
        card.appendChild(heart);
        setTimeout(() => {
            heart.remove();
        }, 900);
    }

    
    const drawer = document.getElementById("commentDrawer");
    const commentsList = document.getElementById("commentsList");
    const commentForm = document.getElementById("commentForm");
    const closeComments = document.getElementById("closeComments");
    const postIdInput = document.getElementById("commentPostId");

   
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

    
    closeComments?.addEventListener("click", () => {
        drawer.classList.add("hidden");
        drawer.classList.remove("flex");
    });

   
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

            
            commentsList.insertAdjacentHTML("beforeend", renderComment(data.comment));

            
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


    const imageModal = document.getElementById("imageModal");
    const modalImage = document.getElementById("modalImage");
    const closeImageModal = document.getElementById("closeImageModal");

    document.addEventListener("click", e => {
        const btn = e.target.closest(".expand-image");
        if (!btn) return;
        e.preventDefault();
        e.stopPropagation();
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


.post-card {
  user-select: none;
  -webkit-user-select: none; 
  -ms-user-select: none;
  -webkit-touch-callout: none;
  -webkit-tap-highlight-color: transparent;
  touch-action: manipulation; 
}

.post-card * {
  user-select: none;
  -webkit-user-select: none;
}


</style>
