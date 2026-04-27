<script>
document.addEventListener("DOMContentLoaded", () => {
  const token = document.querySelector('meta[name="csrf-token"]')?.content;
  const inFlight = new Set();
  const commentState = new Map();
  const isCoarse = window.matchMedia && window.matchMedia("(pointer: coarse)").matches;
  const isTouch = ("ontouchstart" in window) || (navigator.maxTouchPoints > 0) || isCoarse;
  const lastTapByPost = new Map();
  const ignoreButtonClickUntil = new Map();
  const commentsAreaSelector = ".comments-toggle, [id^='comments-'], form[data-comment-form], [data-comment-error], [data-comment-submit]";
  const noDoubleTapSelector = "a, button, input, textarea, select, label, form, .expand-image, .comments-toggle, [data-comment-form], [data-comment-error], [data-comment-submit]";
  const DOUBLE_TAP_MS = 330;
  const DOUBLE_TAP_PX = 24;
  function eventTargetElement(e) {
    return e.target instanceof Element ? e.target : e.target?.parentElement;
  }
  function isInCommentsArea(target){ return Boolean(target?.closest(commentsAreaSelector)); }
  function isLikedByUI(btn){
    const icon = btn?.querySelector('.like-icon');
    if (!icon) return false;
    return icon.classList.contains('fill-current') || icon.getAttribute('fill') === 'currentColor';
  }
  function readLikeCount(btn) {
    return Number.parseInt(btn?.querySelector(".like-count")?.textContent || "0", 10) || 0;
  }
  async function handleLikeButton(btn) {
    if (!btn) return null;
    const postId = btn.dataset.post;
    const likeUrl = btn.dataset.likeUrl;
    if (!postId || inFlight.has(postId)) return null;

    btn.disabled = true;
    btn.classList.add('opacity-80', 'pointer-events-none');

    const previous = { liked: isLikedByUI(btn), likes: readLikeCount(btn) };
    const desiredLiked = !previous.liked;
    const data = await toggleLike(postId, likeUrl, previous, desiredLiked);
    if (!data) {
      btn.disabled = false;
      btn.classList.remove('opacity-80', 'pointer-events-none');
      return null;
    }

    updateLikeUI(btn, Boolean(data.liked), Number.parseInt(data.likes, 10) || 0);

    btn.disabled = false;
    btn.classList.remove('opacity-80', 'pointer-events-none');

    return data;
  }

  // Like button uses AJAX click only (including keyboard activation).
  document.addEventListener("click", async e => {
    const target = eventTargetElement(e);
    if (!target || target.closest(".expand-image")) return;

    const btn = target.closest(".like-btn");
    if (!btn) return;

    const postId = btn.dataset.post;
    if (postId && Date.now() < (ignoreButtonClickUntil.get(postId) || 0)) return;

    e.preventDefault();
    e.stopPropagation();
    await handleLikeButton(btn);
  });

  // Touch double-tap on post card also likes via AJAX.
  document.addEventListener("pointerup", async e => {
    const target = eventTargetElement(e);
    if (!target || target.closest(noDoubleTapSelector) || isInCommentsArea(target)) return;
    if (e.pointerType && e.pointerType !== "touch" && e.pointerType !== "pen") return;

    const card = target.closest(".post-card");
    if (!card) return;

    const postId = card.dataset.postId;
    if (!postId) return;

    const now = Date.now();
    const tap = {
      time: now,
      x: Number.isFinite(e.clientX) ? e.clientX : 0,
      y: Number.isFinite(e.clientY) ? e.clientY : 0,
    };
    const last = lastTapByPost.get(postId);
    lastTapByPost.set(postId, tap);

    if (!last || (now - last.time) > DOUBLE_TAP_MS) return;

    const distance = Math.hypot(tap.x - last.x, tap.y - last.y);
    if (distance > DOUBLE_TAP_PX) return;

    const likeBtn = card.querySelector(".like-btn");
    if (!likeBtn || isLikedByUI(likeBtn)) return;

    e.preventDefault();
    e.stopPropagation();

    ignoreButtonClickUntil.set(postId, Date.now() + 500);

    const data = await handleLikeButton(likeBtn);
    if (data?.liked) popHeart(card);
  }, { passive: false });

  if (!isTouch) {
    document.addEventListener("dblclick", async e => {
      const target = eventTargetElement(e);
      if (!target || target.closest(".like-btn") || target.closest(".expand-image") || isInCommentsArea(target)) return;

      const card = target.closest(".post-card");
      if (!card) return;

      e.preventDefault();
      e.stopPropagation();

      const postId = card.dataset.postId;
      if (!postId || inFlight.has(postId)) return;

      const likeBtn = card.querySelector(".like-btn");
      if (isLikedByUI(likeBtn)) return;

      ignoreButtonClickUntil.set(postId, Date.now() + 350);

      const data = await handleLikeButton(likeBtn);
      if (data?.liked) popHeart(card);
    });
  }
  async function toggleLike(postId, likeUrl, previousState, desiredLiked) {
    if (!postId || inFlight.has(postId)) return null;
    inFlight.add(postId);
    try {
      const url = likeUrl || `/posts/${postId}/like`;
      const res = await fetch(url, {
        method: "POST",
        credentials: "same-origin",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": token,
          "X-Requested-With": "XMLHttpRequest",
          "Accept": "application/json"
        },
        body: JSON.stringify({ liked: desiredLiked })
      });
      if (!res.ok) return null;

      const payload = await res.json().catch(() => null);
      if (payload && typeof payload === 'object' && ('liked' in payload) && ('likes' in payload)) {
        return {
          liked: Boolean(payload.liked),
          likes: Number.parseInt(payload.likes, 10) || 0,
        };
      }

      if (!previousState) return null;
      return {
        liked: desiredLiked,
        likes: Math.max(0, previousState.likes + (desiredLiked ? 1 : -1)),
      };
    } catch(_) {
      return null;
    } finally { inFlight.delete(postId); }
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
  const ensureCommentState = (postId) => {
    if (!commentState.has(postId)) {
      commentState.set(postId, { loaded: false, loading: false, posting: false });
    }
    return commentState.get(postId);
  };

  const setCommentCount = (postId, count) => {
    document.querySelectorAll(`.comments-toggle[data-post='${postId}'] .comment-count`).forEach(el => {
      el.textContent = count;
    });
    const total = document.getElementById(`comments-total-${postId}`);
    if (total) total.textContent = count;
  };

  const setCommentError = (postId, message = '') => {
    const errorEl = document.querySelector(`[data-comment-error='${postId}']`);
    if (!errorEl) return;
    if (message) {
      errorEl.textContent = message;
      errorEl.classList.remove('hidden');
    } else {
      errorEl.textContent = '';
      errorEl.classList.add('hidden');
    }
  };

  async function loadComments(postId, list) {
    const state = ensureCommentState(postId);
    if (state.loading) return;

    state.loading = true;
    list.innerHTML = `<div class="rounded-xl border border-gray-200/80 dark:border-gray-800/80 bg-gray-50/80 dark:bg-gray-900/60 px-3 py-2.5 text-sm text-gray-500 dark:text-gray-400">Loading comments…</div>`;
    try {
      const res = await fetch(`/posts/${postId}/comments`, { headers: { "Accept": "application/json" } });
      if (!res.ok) throw new Error('load_failed');
      const data = await res.json();
      renderComments(list, data.comments);
      setCommentCount(postId, Array.isArray(data.comments) ? data.comments.length : 0);
      state.loaded = true;
      setCommentError(postId, '');
    } catch (_) {
      list.innerHTML = `<div class="rounded-xl border border-red-200 dark:border-red-800 bg-red-50/80 dark:bg-red-900/20 px-3 py-2.5 text-sm text-red-600 dark:text-red-300">Failed to load comments. Please try again.</div>`;
      setCommentError(postId, 'Could not load comments. Check your connection and try again.');
    } finally {
      state.loading = false;
    }
  }

  document.addEventListener("click", async e => {
    const toggle = e.target.closest(".comments-toggle");
    if (!toggle) return;

    const postId = toggle.dataset.post;
    const panel  = document.getElementById(`comments-${postId}`);
    const list   = document.getElementById(`comments-list-${postId}`);
    if (!postId || !panel || !list) return;

    const isOpening = panel.classList.contains("hidden");
    panel.classList.toggle("hidden", !isOpening);
    toggle.setAttribute('aria-expanded', isOpening ? 'true' : 'false');

    if (!isOpening) return;

    const state = ensureCommentState(postId);
    if (!state.loaded) {
      await loadComments(postId, list);
    }
  });
  function renderComments(container, comments) {
    if (!comments?.length) {
      container.innerHTML = `<div class="rounded-xl border border-dashed border-gray-300 dark:border-gray-700 px-3 py-3 text-gray-500 italic text-sm bg-white/50 dark:bg-gray-900/40">No comments yet. Be the first to comment.</div>`;
      return;
    }
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
      <article class="flex items-start gap-3 p-3 rounded-xl bg-white/80 dark:bg-gray-900/70 border border-gray-200 dark:border-gray-800 shadow-sm">
        ${avatar}
        <div class="min-w-0">
          <p class="font-semibold text-sm text-gray-900 dark:text-gray-100">${name}
            <span class="ml-1 text-xs text-gray-500">${when}</span>
          </p>
          <p class="text-gray-700 dark:text-gray-300 text-sm break-words">${text}</p>
        </div>
      </article>`;
  }
  document.addEventListener("submit", async e => {
    const form = e.target.closest("form[data-comment-form]");
    if (!form) return;
    e.preventDefault();
    const postId = form.getAttribute("data-comment-form");
    const input  = form.querySelector("input[name='content']");
    const submitBtn = form.querySelector("[data-comment-submit]");
    const list = document.getElementById(`comments-list-${postId}`);
    const panel = document.getElementById(`comments-${postId}`);
    const toggle = document.querySelector(`.comments-toggle[data-post='${postId}']`);
    const state = ensureCommentState(postId);
    const content = (input.value || '').trim();
    if (!content || state.posting) return;

    setCommentError(postId, '');

    if (panel?.classList.contains('hidden')) {
      panel.classList.remove('hidden');
      toggle?.setAttribute('aria-expanded', 'true');
    }

    if (list && !state.loaded) {
      await loadComments(postId, list);
    }

    state.posting = true;
    if (submitBtn) submitBtn.disabled = true;
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
      if (!res.ok) {
        const payload = await res.json().catch(() => ({}));
        throw new Error(payload?.message || payload?.errors?.content?.[0] || 'Failed to post comment.');
      }
      const data = await res.json();

      if (list) {
        if (list.textContent.includes('No comments yet')) {
          list.innerHTML = '';
        }
        list.insertAdjacentHTML("beforeend", commentItem(data.comment));
        list.scrollTo({ top: list.scrollHeight, behavior: 'smooth' });
      }

      setCommentCount(postId, data.comments ?? 0);
      state.loaded = true;
      input.value = "";
    } catch(error) {
      setCommentError(postId, error?.message || 'Failed to post comment.');
    } finally {
      state.posting = false;
      if (submitBtn) submitBtn.disabled = false;
    }
  });
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
const style = document.createElement('style'); style.textContent = `
@keyframes pop-heart { 0%{transform:scale(.3);opacity:0} 40%{transform:scale(1.35);opacity:1} 100%{transform:scale(1);opacity:0} }
.animate-pop-heart{animation:pop-heart .9s ease forwards}
`; document.head.appendChild(style);
</script>
