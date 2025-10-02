<script>
document.addEventListener("DOMContentLoaded", () => {
  const token = document.querySelector('meta[name="csrf-token"]')?.content;

  // ===== LIKE logic (with debounce & dblclick)
  const inFlight = new Set();
  const suppressUntil = new Map();
  const SUPPRESS_MS = 450;

  const isCoarse = window.matchMedia && window.matchMedia("(pointer: coarse)").matches;
  const isTouch = ("ontouchstart" in window) || (navigator.maxTouchPoints > 0) || isCoarse;

  function suppress(postId){ suppressUntil.set(postId, Date.now() + SUPPRESS_MS); }
  function shouldSuppress(postId){ return (suppressUntil.get(postId) || 0) > Date.now(); }

  document.addEventListener("click", async e => {
    if (e.target.closest(".expand-image")) return;
    const btn = e.target.closest(".like-btn");
    if (!btn) return;

    const postId = btn.dataset.post;
    if (!postId || inFlight.has(postId) || shouldSuppress(postId)) return;

    suppress(postId);
    await toggleLike(postId, btn);
  });

  if (!isTouch) {
    document.addEventListener("dblclick", async e => {
      if (e.target.closest(".like-btn") || e.target.closest(".expand-image")) return;
      const card = e.target.closest(".post-card");
      if (!card) return;
      e.preventDefault(); e.stopPropagation();

      const postId = card.dataset.postId;
      if (!postId || inFlight.has(postId) || shouldSuppress(postId)) return;

      suppress(postId);
      await toggleLike(postId, card.querySelector(".like-btn"));
      popHeart(card);
    });
  } else {
    const lastTapByPost = new Map();
    document.addEventListener("touchstart", e => {
      const card = e.target.closest(".post-card");
      if (!card || e.target.closest(".expand-image")) return;
      const postId = card.dataset.postId;
      const now = Date.now(), last = lastTapByPost.get(postId) || 0;
      if (now - last < 300) { e.preventDefault(); e.stopPropagation(); }
    }, { passive: false });

    document.addEventListener("touchend", async e => {
      const card = e.target.closest(".post-card");
      if (!card || e.target.closest(".expand-image")) return;
      const postId = card.dataset.postId; if (!postId) return;

      const now = Date.now(), last = lastTapByPost.get(postId) || 0;
      lastTapByPost.set(postId, now);
      if (now - last < 300) {
        e.preventDefault(); e.stopPropagation();
        if (inFlight.has(postId) || shouldSuppress(postId)) return;
        suppress(postId);
        await toggleLike(postId, card.querySelector(".like-btn"));
        popHeart(card);
      }
    }, { passive: false });
  }

  async function toggleLike(postId, btn) {
    if (!postId || !btn || inFlight.has(postId)) return;
    inFlight.add(postId);
    try {
      const res = await fetch(`/posts/${postId}/like`, { method: "POST", headers: { "X-CSRF-TOKEN": token, "Accept": "application/json" } });
      if (!res.ok) return;
      const data = await res.json();
      updateLikeUI(btn, data.liked, data.likes);
    } catch(_) {} finally { inFlight.delete(postId); }
  }

  function updateLikeUI(btn, liked, likes) {
    btn.querySelector(".like-count").textContent = likes;
    const icon = btn.querySelector(".like-icon");
    if (liked) { icon.classList.add("fill-current","text-red-600","dark:text-red-500"); icon.classList.remove("text-gray-500","dark:text-gray-400"); icon.setAttribute("fill","currentColor"); }
    else { icon.classList.remove("fill-current","text-red-600","dark:text-red-500"); icon.classList.add("text-gray-500","dark:text-gray-400"); icon.setAttribute("fill","none"); }
  }

  function popHeart(card) {
    const heart = document.createElement("div");
    heart.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
             fill="currentColor" class="w-20 h-20 text-red-500">
            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 
                     2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 
                     3.41.81 4.5 2.09C13.09 3.81 14.76 
                     3 16.5 3 19.58 3 22 5.42 22 
                     8.5c0 3.78-3.4 6.86-8.55 
                     11.54L12 21.35z"/></svg>`;
    heart.className = "absolute inset-0 flex items-center justify-center pointer-events-none animate-pop-heart";
    const prev = card.style.position; if (!prev || prev === "static") card.style.position = "relative";
    card.appendChild(heart); setTimeout(() => heart.remove(), 900);
  }

  // ===== Comments (inline panel per post)
  document.addEventListener("click", async e => {
    const toggle = e.target.closest(".comments-toggle");
    if (!toggle) return;

    const postId = toggle.dataset.post;
    const panel  = document.getElementById(`comments-${postId}`);
    const list   = document.getElementById(`comments-list-${postId}`);

    if (panel.classList.contains("hidden")) {
      panel.classList.remove("hidden");
      list.innerHTML = `<p class="text-gray-500 text-sm">Loading comments…</p>`;
      try {
        const res = await fetch(`/posts/${postId}/comments`, { headers: { "Accept": "application/json" } });
        if (!res.ok) throw 0;
        const data = await res.json();
        renderComments(list, data.comments);
      } catch(_) {
        list.innerHTML = `<p class="text-red-500 text-sm">Failed to load comments</p>`;
      }
    } else {
      panel.classList.add("hidden");
    }
  });

  function renderComments(container, comments) {
    if (!comments?.length) { container.innerHTML = `<p class="text-gray-500 italic text-sm">No comments yet.</p>`; return; }
    container.innerHTML = "";
    comments.forEach(c => container.insertAdjacentHTML("beforeend", commentItem(c)));
  }

  function commentItem(c) {
    const avatar = c.user?.profile_photo_path
      ? `<img src="/storage/${c.user.profile_photo_path}" class="w-8 h-8 rounded-full object-cover">`
      : `<div class="w-8 h-8 rounded-full bg-yellow-500 flex items-center justify-center text-white text-xs font-bold">${(c.user?.name || 'U').charAt(0)}</div>`;
    const name = c.user?.name || 'User';
    const when = c.created_at || '';
    const text = (c.content || '').replace(/[<>&]/g, s => ({'<':'&lt;','>':'&gt;','&':'&amp;'}[s]));
    return `
      <div class="flex items-start gap-3 p-3 rounded-xl bg-white/80 dark:bg-gray-900/70 border border-gray-200 dark:border-gray-800">
        ${avatar}
        <div class="min-w-0">
          <p class="font-semibold text-sm text-gray-900 dark:text-gray-100">${name}
            <span class="ml-1 text-xs text-gray-500">${when}</span>
          </p>
          <p class="text-gray-700 dark:text-gray-300 text-sm break-words">${text}</p>
        </div>
      </div>`;
  }

  // Submit new comment
  document.addEventListener("submit", async e => {
    const form = e.target.closest("form[data-comment-form]");
    if (!form) return;
    e.preventDefault();

    const postId = form.getAttribute("data-comment-form");
    const input  = form.querySelector("input[name='content']");
    const content = (input.value || '').trim();
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
      if (!res.ok) throw 0;
      const data = await res.json();
      const list = document.getElementById(`comments-list-${postId}`);
      if (list) list.insertAdjacentHTML("beforeend", commentItem(data.comment));

      // bump visible counters
      document.querySelectorAll(`[data-post='${postId}'] .comment-count`).forEach(el => { el.textContent = data.comments; });

      input.value = "";
    } catch(_) { /* silently fail */ }
  });

  // ===== Image Lightbox
  const imageModal = document.getElementById("imageModal");
  const modalImage = document.getElementById("modalImage");
  const closeImageModal = document.getElementById("closeImageModal");

  document.addEventListener("click", e => {
    const btn = e.target.closest(".expand-image"); if (!btn) return;
    e.preventDefault(); e.stopPropagation();
    const img = btn.closest("div").querySelector(".post-image"); if (!img) return;
    modalImage.src = img.dataset.src || img.src;
    imageModal.classList.remove("hidden"); imageModal.classList.add("flex");
  });

  closeImageModal?.addEventListener("click", () => { imageModal.classList.add("hidden"); imageModal.classList.remove("flex"); });
  imageModal?.addEventListener("click", e => { if (e.target === imageModal) { imageModal.classList.add("hidden"); imageModal.classList.remove("flex"); } });

});

// lil heart animation
const style = document.createElement('style'); style.textContent = `
@keyframes pop-heart { 0%{transform:scale(.3);opacity:0} 40%{transform:scale(1.35);opacity:1} 100%{transform:scale(1);opacity:0} }
.animate-pop-heart{animation:pop-heart .9s ease forwards}
`; document.head.appendChild(style);
</script>
