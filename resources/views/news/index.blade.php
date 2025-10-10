@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 py-6 sm:py-8 space-y-4 sm:space-y-6">

  @php
    $hasPaginator = method_exists($news, 'total');
    $totalNews  = $hasPaginator ? $news->total() : (is_countable($news) ? count($news) : 0);
  @endphp

  <nav aria-label="Breadcrumb"
       class="rounded-2xl bg-white/70 dark:bg-gray-900/60 backdrop-blur
              border border-gray-200/70 dark:border-gray-800/70 shadow-sm px-3 sm:px-4 py-2">
    <ol class="flex items-center flex-wrap gap-1.5 text-xs sm:text-sm text-gray-600 dark:text-gray-300">
      <li>
        <a href="{{ url('/') }}"
           class="inline-flex items-center gap-1 px-2 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition">
          <span class="font-semibold text-gray-900 dark:text-gray-100">PostPit</span>
        </a>
      </li>
      <li aria-hidden="true" class="text-gray-400">
        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
      </li>
      <li class="text-gray-900 dark:text-gray-100 font-semibold">News</li>
    </ol>
  </nav>

  <header
    class="relative overflow-hidden rounded-3xl p-6 sm:p-8
           bg-gradient-to-br from-yellow-50 via-white to-yellow-100
           dark:from-gray-900 dark:via-gray-900/70 dark:to-gray-900
           border border-yellow-200/60 dark:border-gray-800 shadow-2xl">
    <div class="absolute inset-0 -z-10">
      <div class="absolute -right-16 -top-10 h-56 w-56 rounded-full blur-3xl bg-yellow-300/30 dark:bg-yellow-500/20"></div>
      <div class="absolute -left-20 -bottom-16 h-64 w-64 rounded-full blur-3xl bg-orange-300/25 dark:bg-orange-400/15"></div>
    </div>

    <div class="relative z-10 flex flex-col md:flex-row md:items-start md:justify-between gap-4">
      <div class="max-w-2xl">
        <div class="inline-flex items-center gap-2 mb-1">
          <span class="h-2 w-2 rounded-full bg-yellow-400 shadow-[0_0_16px_theme(colors.yellow.300)]"></span>
          <span class="text-[11px] font-semibold tracking-wide uppercase text-yellow-900/80 dark:text-yellow-100/90">Updates</span>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight
                   bg-clip-text text-transparent bg-gradient-to-b
                   from-gray-900 to-gray-600 dark:from-white dark:to-gray-300">
          News
        </h1>
        <p class="mt-2 text-sm sm:text-base text-gray-700 dark:text-gray-300">
          Browse the latest announcements and community highlights.
        </p>

        @if($totalNews)
          <div class="mt-3 inline-flex items-center gap-2 text-[11px] sm:text-xs font-semibold
                      text-yellow-900 dark:text-yellow-100
                      bg-yellow-400/15 dark:bg-yellow-500/20
                      border border-yellow-300/40 dark:border-yellow-500/40
                      rounded-full px-3 py-1">
            <span class="h-1.5 w-1.5 rounded-full bg-yellow-400"></span>
            {{ number_format($totalNews) }} {{ Str::plural('post', $totalNews) }}
          </div>
        @endif
      </div>

      @if(auth()->user() && auth()->user()->role === 'admin')
        <div class="md:self-start">
          <a href="{{ route('news.create') }}"
             class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full
                    bg-yellow-400 text-gray-900 text-sm font-semibold
                    border border-yellow-300/70 shadow-sm hover:shadow-md hover:-translate-y-0.5
                    transition dark:bg-yellow-500 dark:hover:bg-yellow-400 dark:text-gray-900">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Create News
          </a>
        </div>
      @endif
    </div>
  </header>

  <section class="space-y-6 sm:space-y-8">
    @forelse ($news as $item)
      <article class="p-4 sm:p-6 rounded-3xl
                      bg-white/80 dark:bg-gray-900/70 backdrop-blur
                      border border-gray-200/70 dark:border-gray-800/70
                      shadow-[0_16px_40px_-20px_rgba(0,0,0,0.30)]
                      hover:shadow-[0_28px_60px_-28px_rgba(0,0,0,0.45)]
                      transition group">

        @if($item->image)
          <div class="relative overflow-hidden rounded-2xl mb-4">
            <img
              src="{{ Storage::url($item->image) }}"
              alt="{{ $item->title }}"
              data-expand-image
              class="w-full h-80 sm:h-96 md:h-[28rem] object-cover cursor-zoom-in transition-transform duration-300 group-hover:scale-[1.01]"
            />
            <button
              type="button"
              class="absolute top-3 right-3 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full
                     bg-white/80 dark:bg-gray-900/60 backdrop-blur
                     text-gray-900 dark:text-gray-100 text-xs font-semibold
                     border border-gray-200/80 dark:border-gray-700/70 shadow-sm hover:shadow-md"
              data-expand-image
              aria-label="Expand image"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 9V4h5M20 15v5h-5M4 15v5h5M20 9V4h-5"/>
              </svg>
              Expand
            </button>
          </div>
        @endif

        <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 dark:text-gray-100">
          {{ $item->title }}
        </h2>

        <p class="text-sm sm:text-base text-gray-700 dark:text-gray-300 mt-2 leading-relaxed">
          {{ Str::limit($item->content, 400) }}
        </p>

        <div class="mt-3 flex items-center justify-between text-xs sm:text-sm text-gray-500 dark:text-gray-400">
          <span>Published {{ $item->created_at->diffForHumans() }}</span>
        </div>
      </article>
    @empty
      <div class="p-10 text-center rounded-3xl
                  bg-white/80 dark:bg-gray-900/70 backdrop-blur
                  border border-gray-200/70 dark:border-gray-800/70 shadow-xl">
        <p class="text-gray-600 dark:text-gray-400">No news yet.</p>
        @if(auth()->user() && auth()->user()->role === 'admin')
          <a href="{{ route('news.create') }}"
             class="inline-flex items-center gap-1.5 mt-4 px-3.5 py-2 rounded-full
                    bg-yellow-400 text-gray-900 border border-yellow-300/70 shadow-sm
                    hover:shadow-md hover:-translate-y-0.5 transition
                    dark:bg-yellow-500 dark:hover:bg-yellow-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Create the first post
          </a>
        @endif
      </div>
    @endforelse
  </section>

  @if(method_exists($news, 'hasPages') && $news->hasPages())
    <div>
      {{ $news->links() }}
    </div>
  @endif
</div>

{{-- Lightbox --}}
<div id="imageModal" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50">
  <button id="closeImageModal" class="absolute top-6 right-8 text-white text-3xl leading-none w-10 h-10 rounded-full hover:bg-white/10">&times;</button>
  <img id="modalImage" src="" class="max-h-[92%] max-w-[92%] rounded-xl shadow-2xl" alt="Preview">
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('imageModal');
  const modalImg = document.getElementById('modalImage');
  const closeBtn = document.getElementById('closeImageModal');

  const openModal = (src) => {
    if (!src) return;
    modalImg.src = src;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.classList.add('overflow-hidden');
  };

  const closeModal = () => {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    modalImg.src = '';
    document.body.classList.remove('overflow-hidden');
  };

  document.addEventListener('click', (e) => {
    const target = e.target.closest('[data-expand-image]');
    if (target) {
      const img = target.closest('div')?.querySelector('img[data-expand-image]');
      const src = img?.getAttribute('src') || target.getAttribute('src');
      openModal(src);
    }
  });

  closeBtn?.addEventListener('click', closeModal);
  modal?.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
  window.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });
});
</script>
@endsection
